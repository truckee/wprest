<?php

namespace tests\AppBundle\Controller;

use Liip\FunctionalTestBundle\Test\WebTestCase;

/**
 * Description of NoneControllerTest
 *
 * @author George
 */
class NoneControllerTest extends WebTestCase
{
    public function setup() {
        $this->loadFixtures(array(
            'AppBundle\DataFixtures\ORM\UsersMembers'
        ));
    }

    public function testBasicAuth() {
        $client = static::createClient();

        $crawler = $client->request(
                'GET', '/get_user/bborko@bogus.info', [], [], ['PHP_AUTH_USER' => 'admin',
            'PHP_AUTH_PW' => '123Abc',]
        );
        $this->assertSame(200, $client->getResponse()->getStatusCode());
    }

    public function testAPISetPassword() {
        $client = static::createClient();

        $crawler = $client->request(
                'POST', 'http://wprest/set_password', [], [], [
                    'HTTP_Api-key' => '3e2ec79352d2e9cbd76ad409d968ee435af6695c',
                    'CONTENT_TYPE' => 'application/json',], 
                '{"email":"developer@bogus.info"}'
        );

        $this->assertSame(200, $client->getResponse()->getStatusCode());
    }

    public function testAPIReetPassword() {
        $client = static::createClient();

        $crawler = $client->request(
                'POST', 'http://wprest/reset_password', [], [], [
                    'HTTP_Api-key' => '3e2ec79352d2e9cbd76ad409d968ee435af6695c',
                    'CONTENT_TYPE' => 'application/json',], 
                '{"email":"developer@bogus.info", "hash":"xyzpm"}'
        );

        $this->assertSame(200, $client->getResponse()->getStatusCode());
    }

}
