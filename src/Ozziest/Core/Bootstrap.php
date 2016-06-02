<?php namespace Ozziest\Core;

use Symfony\Component\HttpFoundation\Request as SymfonyRequest;
use Symfony\Component\HttpFoundation\Response as SymfonyResponse;
use Symfony\Component\Routing\Matcher\UrlMatcher;
use Symfony\Component\Routing\RequestContext;
use Symfony\Component\HttpFoundation\AcceptHeader;
use Symfony\Component\Routing\Exception\MethodNotAllowedException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Symfony\Component\Routing\Exception\ResourceNotFoundException;
use Illuminate\Database\Capsule\Manager as Capsule;
use Monolog\Logger as MonoLogger;
use Philo\Blade\Blade;
use Ozziest\Windrider\ValidationException;
use Ozziest\Windrider\Windrider;
use Ozziest\Core\Exceptions\UserException;
use Exception, Lifecycle, Router, DI;

use Ozziest\Core\HTTP\Response;
use Ozziest\Core\HTTP\Request;
use Ozziest\Core\Data\DB;
use Ozziest\Core\Data\Session;
use Ozziest\Core\System\Logger;
use Ozziest\Core\System\DIManager;

class Bootstrap {

    private $request;
    private $response;
    private $db;
    private $matcher;
    private $logger;

    public function bootstrap()
    {
        try 
        {
            class_alias('\Ozziest\Core\HTTP\Router', 'Router');
            $this->initLogger();
            $this->initSetups();
            $this->initConfigurations();
            $this->initRequest();
            $this->initResponse();
            $this->initDependencies();
            $this->initDatabase();
            $this->initErrorHandler();
            $this->initApplicationLayers();
            $this->callAppcalition();
        }
        catch (ModelNotFoundException $exception)
        {
            $this->showError($exception, 400, "Record not found!");
        }
        catch (ValidationException $exception) 
        {
            $this->db->rollBack();
            $this->response->json(['message' => Windrider::getErrors()], 406);
        }
        catch (UserException $exception)
        {
            $this->showError($exception, $exception->getCode());
        }
        catch (MethodNotAllowedException $exception) 
        {
            $this->showError($exception, 404, "Method not found!");
        }
        catch (ResourceNotFoundException $exception)
        {
            $this->showError($exception, 404, "Request couldn't be resolved!.");
        }
        catch (Exception $exception)
        {
            $this->showError($exception, 500);
        }        
        
    }
    
    private function initDependencies()
    {
        DI::setManager(new DIManager());
    }
    
    private function initLogger()
    {
        $this->logger = new Logger(new MonoLogger('sorucevap'));
    }
    
    private function showError($exception, $status = 500, $message = null)
    {

        if ($this->db !== null)
        {
            $this->db->rollBack();
        }

        if ($status === 0)
        {
            $status = 400;
        }
    
        $this->failOnProduction($exception);
        
        if ($message === null)
        {
            $message = $exception->getMessage();
        }
        
        if ($this->request !== null) 
        {
            $accept = AcceptHeader::fromString($this->request->headers->get('Accept'));
            if ($accept->has('application/json')) 
            {
                return $this->response->json(['message' => $message], $status);
            }
        }
        
        $this->logger->exception($exception);
        
        if ($this->response !== null) {
            $this->response->view($status, ['exception' => $exception], $status);
        }

    }

    private function failOnProduction($exception)
    {
        if (getenv('environment') !== "production") {
            throw $exception;
        }
    }
    
    private function initApplicationLayers()
    {
        require_once ROOT.'App/bootstrap.php';
        require_once ROOT.'App/routes.php';
    }
    
    private function initErrorHandler()
    {
        $whoops = new \Whoops\Run();
        $whoops->pushHandler(new \Whoops\Handler\PrettyPageHandler());
        $whoops->register();
    }
    
    private function initDatabase()
    {
        $this->db = new DB(new Capsule());
        $this->db->connect();
    }
    
    private function initResponse()
    {
        $this->response = new Response(
            $this->request, 
            new SymfonyResponse(),
            new Blade(ROOT.'resource/views', ROOT.'resource/cache')
        );
    }
    
    private function initRequest()
    {
        $this->request = SymfonyRequest::createFromGlobals();
        $context = new RequestContext();
        $context->fromRequest($this->request);
        $this->matcher = new UrlMatcher(Router::getCollection(), $context);        
    }
    
    private function initSetups()
    {
        // Zaman dilimi ayarlanır
        // date_default_timezone_set('Europe/Istanbul');
    }

    private function callAppcalition()
    {
        // Controller çalıştırılır
        $parameters = $this->matcher->match($this->request->getPathInfo());

        foreach ($parameters["middlewares"] as $key => $middleware)
        {
            $this->callMiddleware($middleware);
        }
        
        // Session bilgiriyle yeni bir kullanıcı oluştulur.
        $session = new Session(Lifecycle::get('user'));

        // Controller oluşturulur.
        $controller = new $parameters['controller']($session, $this->db, $this->logger);
        $this->request->parameters = $parameters;
        
        // Bağımlılık enjeksionları gerçekleştirilir.
        $arguments = [
            new Request($this->request),
            $this->response
        ];

        // Controller çağrılır
        $this->db->transaction();
        $content = call_user_func_array([$controller, $parameters['method']], $arguments);
        $this->db->commit();
    }

    private function callMiddleware($name)
    {
        $name = "\App\Middlewares\\".$name;
        if (!class_exists($name)) 
        {
            throw new Exception("Middleware class not found: ".$name);
        }
        $instance = new $name();
        $instance->exec($this->request, $this->db);
    }

    
    private function initConfigurations()
    {
        $configurations = json_decode(file_get_contents(ROOT.'.env.config.json'));
        
        if ($configurations === NULL)
        {
            throw new Exception("Configuration file is not correct!");
        }
        
        foreach ($configurations as $key => $value) 
        {
            putenv("$key=$value");
        }
    }

}