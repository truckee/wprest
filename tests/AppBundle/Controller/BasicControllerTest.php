<?php

namespace tests\AppBundle\Controller;

use Liip\FunctionalTestBundle\Test\WebTestCase;

/**
 * Description of BasicControllerTest
 *
 * @author George
 */
class BasicControllerTest extends WebTestCase
{

    public function setup() {
        $this->loadFixtures(array(
            'AppBundle\DataFixtures\ORM\UsersMembers'
        ));
    }

    public function testBasicAuth() {
//        $client = static::createClient([], ['Authorization' => 'Basic YWRtaW46MTIzQWJj',]);
        $client = static::createClient([], ['PHP_AUTH_USER' => 'admin',
            'PHP_AUTH_PW' => '123Abc',]);

        $crawler = $client->request(
                'GET', '/basic/get_user/bborko@bogus.info'
        );
        $this->assertSame(200, $client->getResponse()->getStatusCode());
    }

    public function testBasicSetPassword() {
        $client = static::createClient();

        $crawler = $client->request(
                'POST', 'http://wprest/basic/set_password', [], [], [
            'PHP_AUTH_USER' => 'admin',
            'PHP_AUTH_PW' => '123Abc',
            'CONTENT_TYPE' => 'application/json',], '{"email":"developer@bogus.info"}'
        );

        $this->assertSame(200, $client->getResponse()->getStatusCode());
    }

}
