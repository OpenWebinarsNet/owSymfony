<?php

namespace cursosBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use cursosBundle\Entity\Cursos;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Nelmio\ApiDocBundle\Annotation\ApiDoc;
use Swagger\Annotations as SWG;
use Nelmio\ApiDocBundle\Annotation\Model;

class DefaultController extends Controller
{
    const ATTR_PARAM_NAME = "name";
    const ATTR_PARAM_DESCRIPTION = "description";

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

    public function indexAction()
    {
        return $this->render('cursosBundle:Default:index.html.twig');
    }

    /**
     * @ApiDoc(
     *  description="Devolveremos un curso especifico",
     *  requirements={
     *      {
     *          "name"="id",
     *          "dataType"="integer",
     *          "requirement"="\d+",
     *          "description"="Id del curso"
     *      }
     *  },
     *
     *  output={"collection"=false, "collectionName"="classes", "class"="cursosBundle\Entity\Cursos"}
     * )
     */
    public function getCourseAction($id)
    {

        $courseService = $this->get("cursos.curso");
        $course = $courseService->getCourse($id);
        if ($course !== null) {
            $helpersService = $this->get("app.helpers");
            $httpResponse = $helpersService->collectionToHttpJsonResponse($course);
        } else {
            $httpResponse = $this->responseKO();
        }

        return $httpResponse;

    }


    public function postCourseAction(Request $request)
    {

        $nameParam = $request->get(self::ATTR_PARAM_NAME, null);
        $descriptionParam = $request->get(self::ATTR_PARAM_DESCRIPTION, null);

        $course = new Cursos();
        $course->setName($nameParam);
        $course->setDescription($descriptionParam);

        $courseService = $this->get("cursos.curso");

        $response = $courseService->createCourse($course);
        if ($response) {
            $httpResponse = $this->responseOK();
        } else {
            $httpResponse = $this->responseKO();
        }

        return $httpResponse;

    }

    /**
     * @ApiDoc(
     *  description="Actualiza un curso",
     *  requirements={
     *      {
     *          "name"="id",
     *          "dataType"="integer",
     *          "requirement"="\d+",
     *          "description"="Id del curso"
     *      }
     *  },
     *  parameters={
     *      {"name"="name", "dataType"="string", "required"=true, "description"="nombre del curso"},
     *      {"name"="description", "dataType"="string", "required"=true, "description"="descripcion"}
     *  }
     * )
     */
    public function putCourseAction($id)
    {

        $courseService = $this->get("cursos.curso");
        $response = $courseService->putCourse($id);
        if ($response) {
            $httpResponse = $this->responseOK();
        } else {
            $httpResponse = $this->responseKO();
        }

        return $httpResponse;

    }

    /**
     * @ApiDoc(
     *  description="Borra un curso",
     *  requirements={
     *      {
     *          "name"="id",
     *          "dataType"="integer",
     *          "requirement"="\d+",
     *          "description"="Id del curso"
     *      }
     *  }
     * )
     */
    public function deleteCourseAction($id)
    {

        $courseService = $this->get("cursos.curso");
        $response = $courseService->deleteCourse($id);
        if ($response) {
            $httpResponse = $this->responseOK();
        } else {
            $httpResponse = $this->responseKO();
        }

        return $httpResponse;

    }
}
