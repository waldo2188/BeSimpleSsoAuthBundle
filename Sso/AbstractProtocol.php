<?php

namespace BeSimple\SsoAuthBundle\Sso;

use BeSimple\SsoAuthBundle\Security\Core\Authentication\Token\SsoToken;

/**
 * @author: Jean-François Simon <contact@jfsimon.fr>
 */
abstract class AbstractProtocol extends AbstractComponent implements ProtocolInterface
{
    /**
     * {@inheritdoc}
     */
    public function processLogout(SsoToken $token)
    {
        // does nothing most of the case
    }
}
