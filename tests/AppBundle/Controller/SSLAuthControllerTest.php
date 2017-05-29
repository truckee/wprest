<?php

namespace tests\AppBundle\Controller;

use Liip\FunctionalTestBundle\Test\WebTestCase;

/**
 * Description of APIControllerTest
 *
 * @author George
 */
class SSLAuthControllerTest extends WebTestCase
{

    public function setup() {
        $this->loadFixtures(array(
            'AppBundle\DataFixtures\ORM\UsersMembers'
        ));
    }

    public function testAPIkey() {
        $client = static::createClient();

        $crawler = $client->request(
                'GET', 'https://wprest/api/get_user/bborko@bogus.info', [], [], ['HTTP_Api-key' => '3e2ec79352d2e9cbd76ad409d968ee435af6695c']
        );
        $this->assertSame(200, $client->getResponse()->getStatusCode());
    }

    public function testAPISetPassword() {
        $client = static::createClient();

        $crawler = $client->request(
                'POST', 'https://wprest/api/set_password', [], [], [
                    'HTTP_Api-key' => '3e2ec79352d2e9cbd76ad409d968ee435af6695c',
                    'CONTENT_TYPE' => 'application/json',], 
                '{"email":"developer@bogus.info"}'
        );

        $this->assertSame(200, $client->getResponse()->getStatusCode());
    }

    public function testBasicAuth() {
        $client = static::createClient([], ['PHP_AUTH_USER' => 'admin',
            'PHP_AUTH_PW' => '123Abc',]);

        $crawler = $client->request(
                'GET', 'https://wprest/basic/get_user/bborko@bogus.info'
        );
        $this->assertSame(200, $client->getResponse()->getStatusCode());
    }

    public function testBasicSetPassword() {
        $client = static::createClient();

        $crawler = $client->request(
                'POST', 'https://wprest/basic/set_password', [], [], [
            'PHP_AUTH_USER' => 'admin',
            'PHP_AUTH_PW' => '123Abc',
            'CONTENT_TYPE' => 'application/json',], '{"email":"developer@bogus.info"}'
        );

        $this->assertSame(200, $client->getResponse()->getStatusCode());
    }

    public function testNoneAuth() {
        $client = static::createClient();

        $crawler = $client->request(
                'GET', 'https://wprest/none/get_user/bborko@bogus.info', [], [], []);
        $this->assertSame(200, $client->getResponse()->getStatusCode());
    }

    public function testNoneSetPassword() {
        $client = static::createClient();

        $crawler = $client->request(
                'POST', 'https://wprest/none/set_password', [], [], [
                    'CONTENT_TYPE' => 'application/json',], 
                '{"email":"developer@bogus.info"}'
        );

        $this->assertSame(200, $client->getResponse()->getStatusCode());
    }

}
