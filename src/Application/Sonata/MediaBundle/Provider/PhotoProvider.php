<?php
namespace Sonata\MediaBundle\Provider;

use Sonata\MediaBundle\Provider\BaseProvider;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\MediaBundle\Model\MediaInterface;
use Symfony\Component\Form\Form;
use Sonata\MediaBundle\Provider\MediaProviderInterface;

class PhotoProvider extends ImageProvider
{
    /**
     * {@inheritdoc}
     */
    protected function doTransform(MediaInterface $media)
    {
        parent::doTransform($media);

        var_dump($media->getBinaryContent());exit;
    }
}