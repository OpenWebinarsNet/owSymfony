<?php

namespace OngBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Validator\Constraints as Assert;
use Nelmio\ApiDocBundle\Annotation\ApiDoc;

class DefaultController extends Controller
{

    const ATTR_PARAM_JSON = 'json';
    const ATTR_PARAM_TEST = 'test';


    public function indexAction()
    {
        $jsonTest = ["prueba" => 4];
        $helpersService = $this->get("app.helpers");
        $httpResponse = $helpersService->collectionToHttpJsonResponse($jsonTest);

        return $httpResponse;
        //return $this->render('OngBundle:Default:index.html.twig');
    }

    public function listAction()
    {
        return $this->getUsers();
    }

    public function loginAction(Request $request)
    {
        $jsonParams = $request->get(self::ATTR_PARAM_JSON, null);

        $helpersService = $this->get("app.helpers");
        $httpResponse = $helpersService->collectionToHttpJsonResponse($jsonParams);

        return $httpResponse;
    }

    public function setTestAction($_test) {
        //echo "test -> ".$_test; die();

        /*$helpersService = $this->get("app.helpers");
        $httpResponse = $helpersService->collectionToHttpJsonResponse($_test);

        return $httpResponse;*/
        $userService = $this->get("ong.user");

        $userService->insertUser();
        //$userService->deleteUser();
        die();
    }

    public function createAction(Request $request)
    {
        /*$jsonParams = $request->get(self::ATTR_PARAM_JSON, null);
        var_dump($request);

        $emailConstraint = new Assert\Email();

        echo "login action";
        die();*/

        $jsonTest = ["code" => 0];
        $helpersService = $this->get("app.helpers");
        $httpResponse = $helpersService->collectionToHttpJsonResponse($jsonTest);
        return $httpResponse;
    }

    private function getUsers()
    {

        $userService = $this->get("ong.user");
        $users = $userService->getUsers();

        $helpersService = $this->get("app.helpers");
        $httpResponse = $helpersService->collectionToHttpJsonResponse($users);

        return $httpResponse;

    }

    private function responseOK() {
        $jsonTest = ["code" => 0];
        $helpersService = $this->get("app.helpers");
        $httpResponse = $helpersService->collectionToHttpJsonResponse($jsonTest);
        return $httpResponse;
    }

    private function responseKO() {
        $jsonTest = ["code" => "error"];
        $helpersService = $this->get("app.helpers");
        $httpResponse = $helpersService->collectionToHttpJsonResponse($jsonTest);
        return $httpResponse;
    }

    public function deleteAction($id)
    {
        $userService = $this->get("ong.user");
        $result = $userService->deleteUser($id);

        if ($result) {
            return $this->responseOK();
        } else {
            return $this->responseKO();
        }
    }
}
