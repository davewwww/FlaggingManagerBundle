<?php

namespace Dwo\FlaggingManagerBundle\Controller;

use Dwo\Flagging\Model\FeatureManagerInterface;
use Dwo\Flagging\Serializer\FeatureSerializer;
use Dwo\FlaggingManager\Model\Feature;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use Symfony\Component\Yaml\Yaml;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

/**
 * Class FeatureController
 *
 * @author Dave Www <davewwwo@gmail.com>
 */
class FeatureController extends Controller
{
    /**
     * @return Response
     *
     * @throws \Exception
     */
    public function listAction()
    {
        /** @var FeatureManagerInterface $manager */
        $manager = $this->container->get('dwo_flagging_manager.manager');

        return $this->render(
            'DwoFlaggingManagerBundle::list.html.twig',
            array(
                'index_template' => $this->container->getParameter('dwo_flagging_manager.index_template'),
                'features'       => $manager->findAllFeatures()
            )
        );
    }

    /**
     * @param string $featureName
     *
     * @return Response
     *
     * @throws \Exception
     */
    public function readAction($featureName)
    {
        $managerName = 'dwo_flagging_manager.manager';
        if ($this->getRequest()->query->has('live')) {
            $managerName = 'dwo_flagging.manager.feature';
        }

        /** @var FeatureManagerInterface $manager */
        $manager = $this->container->get($managerName);
        $feature = $manager->findFeatureByName($featureName);

        if (null === $feature) {
            throw new \Exception(sprintf('Feature "%s" not found', $featureName));
        }

        $featureArray = FeatureSerializer::serialize($feature);
        $featureYaml = Yaml::dump($featureArray, 3, 2);

        $voterManager = $this->container->get('dwo_flagging.manager.voter');
        $voters = array_keys($voterManager->getAllVoters());

        return $this->render(
            'DwoFlaggingManagerBundle::edit.html.twig',
            array(
                'index_template' => $this->container->getParameter('dwo_flagging_manager.index_template'),
                'feature'        => $feature,
                'data'           => $featureYaml,
                'voters'         => $voters,
            )
        );
    }

    /**
     * @param string $featureName
     *
     * @return Response
     *
     * @throws \Exception
     */
    public function writeAction($featureName)
    {
        $dataYaml = $this->getRequest()->request->get('data');

        $form = new Feature();
        $form->setName($featureName);
        $form->setContent($dataArray = Yaml::parse($dataYaml));

        /** @var ValidatorInterface $validator */
        $validator = $this->container->get('validator');
        $violations = $validator->validate($form);
        if ($violations->has(0)) {
            throw new \Exception($violations->get(0));
        }

        $featureHandler = $this->container->get('dwo_flagging_manager.handler');
        $featureHandler->saveFeature($featureName, $dataArray);

        return new Response('ok<p><a href="?">weiter</a>');
    }

    /**
     * @return Request
     */
    public function getRequest()
    {
        return $this->container->get('request_stack')->getCurrentRequest();
    }

    /**
     * Renders a view.
     *
     * @param string   $view       The view name
     * @param array    $parameters An array of parameters to pass to the view
     * @param Response $response   A response instance
     *
     * @return Response A Response instance
     */
    public function render($view, array $parameters = array(), Response $response = null)
    {
        return $this->container->get('templating')->renderResponse($view, $parameters, $response);
    }
}