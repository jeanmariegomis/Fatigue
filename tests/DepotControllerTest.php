<?php

namespace App\Tests;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class DepotControllerTest extends WebTestCase
{
    public function testSomething()
    {
        {
            $client = static::createClient([],[ 
                'PHP_AUTH_USER' => 'user' ,
                'PHP_AUTH_PW'   => 'pass'
            ]);
            $crawler = $client->request('GET', '/api/depot',[],[],['CONTENT_TYPE'=>"application/json"],
            
            
            '{
                "Entreprise": 1,
                "Montant": 2000000
            }'
    
        );
            $rep=$client->getResponse(); 
            $this->assertSame(201,$client->getResponse()->getStatusCode());
            
        }
    }
}
