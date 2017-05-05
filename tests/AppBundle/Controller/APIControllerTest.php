<?php

namespace tests\AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

/**
 * Description of APIControllerTest
 *
 * @author George
 */
class APIControllerTest extends WebTestCase
{

    public function testAPIkey() {
        $client = static::createClient();

        $crawler = $client->request(
                'GET', '/api/get_user/bborko@bogus.info', [], [], ['HTTP_Api-key' => '3e2ec79352d2e9cbd76ad409d968ee435af6695c']
        );
        $this->assertSame(200, $client->getResponse()->getStatusCode());
    }

}
