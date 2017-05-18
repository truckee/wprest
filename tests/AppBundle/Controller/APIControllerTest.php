<?php

namespace tests\AppBundle\Controller;

use Liip\FunctionalTestBundle\Test\WebTestCase;

/**
 * Description of APIControllerTest
 *
 * @author George
 */
class APIControllerTest extends WebTestCase
{

    public function setup() {
        $this->loadFixtures(array(
            'AppBundle\DataFixtures\ORM\UsersMembers'
        ));
    }

    public function testAPIkey() {
        $client = static::createClient();

        $crawler = $client->request(
                'GET', '/api/get_user/bborko@bogus.info', [], [], ['HTTP_Api-key' => '3e2ec79352d2e9cbd76ad409d968ee435af6695c']
        );
        $this->assertSame(200, $client->getResponse()->getStatusCode());
    }

    public function testAPISetPassword() {
        $client = static::createClient();

        $crawler = $client->request(
                'POST', 'http://wprest/api/set_password', [], [], [
                    'HTTP_Api-key' => '3e2ec79352d2e9cbd76ad409d968ee435af6695c',
                    'CONTENT_TYPE' => 'application/json',], 
                '{"email":"developer@bogus.info"}'
        );

        $this->assertSame(200, $client->getResponse()->getStatusCode());
    }
    
    public function testAPIResetPassword() {
        $client = static::createClient();

        $crawler = $client->request(
                'POST', 'http://wprest/api/reset_password', [], [], [
                    'HTTP_Api-key' => '3e2ec79352d2e9cbd76ad409d968ee435af6695c',
                    'CONTENT_TYPE' => 'application/json',], 
                '{"email":"developer@bogus.info", "hash":"xyzpm"}'
        );

        $this->assertSame(200, $client->getResponse()->getStatusCode());
    }

}
