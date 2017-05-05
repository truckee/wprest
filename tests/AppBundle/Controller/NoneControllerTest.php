<?php

namespace tests\AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

/**
 * Description of NoneControllerTest
 *
 * @author George
 */
class NoneControllerTest extends WebTestCase
{

    public function testBasicAuth() {
        $client = static::createClient();

        $crawler = $client->request(
                'GET', '/get_user/bborko@bogus.info', [], [], ['PHP_AUTH_USER' => 'admin',
            'PHP_AUTH_PW' => '123Abc',]
        );
        $this->assertSame(200, $client->getResponse()->getStatusCode());
    }

}
