<?php
/**
 * Import para o autoload PSR-0
 */
require_once __DIR__ . '/vendor/autoload.php';

$app = new Silex\Application();

/**
 * Configuração do Twig
 */
$app->register(new Silex\Provider\TwigServiceProvider(), array(
    'twig.path' => __DIR__ . '/src/Resources/views',
));

/**
 * Registrando o Forms e Validadores
 */
$app->register(new Silex\Provider\TranslationServiceProvider(), array(
    'translator.messages' => array(),
));

/**
 * Action do Controller
 */
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * ========================================================
 * Rotas de Frontend
 * ========================================================
 */
$app->get("/", function() use ($app) {
    return $app['twig']->render('index.html.twig', array());
});

$app->run();