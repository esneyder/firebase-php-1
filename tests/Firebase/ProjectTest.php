<?php

namespace Tests\Firebase;

use Firebase\Auth\Token\Handler;
use Firebase\Database;
use Firebase\Project;
use Firebase\ServiceAccount;
use GuzzleHttp\Psr7\Uri;
use Tests\FirebaseTestCase;

class ProjectTest extends FirebaseTestCase
{
    /**
     * @var ServiceAccount|\PHPUnit_Framework_MockObject_MockObject
     */
    private $serviceAccount;

    /**
     * @var Uri
     */
    private $databaseUri;

    /**
     * @var Handler
     */
    private $tokenHandler;

    /**
     * @var Project
     */
    private $firebase;

    protected function setUp()
    {
        $this->serviceAccount = $this->createServiceAccountMock();
        $this->databaseUri = new Uri('https://database-uri.tld');
        $this->tokenHandler = new Handler('projectid', 'clientEmail', 'privateKey');

        $this->firebase = new Project($this->serviceAccount, $this->databaseUri, $this->tokenHandler);
    }

    public function testWithDatabaseUri()
    {
        $firebase = $this->firebase->withDatabaseUri('https://some-other-uri.tld');

        $this->assertInstanceOf(Project::class, $firebase);
        $this->assertNotSame($this->firebase, $firebase);
    }

    public function testGetDatabase()
    {
        $db = $this->firebase->getDatabase();

        $this->assertInstanceOf(Database::class, $db);
    }

    public function testAsUserWithClaims()
    {
        $firebase = $this->firebase->asUserWithClaims('uid');
        $this->assertInstanceOf(Project::class, $firebase);
        $this->assertNotSame($this->firebase, $firebase);
    }

    public function testGetTokenHandler()
    {
        $this->assertInstanceOf(Handler::class, $this->firebase->getTokenHandler());
    }
}
