<?php

namespace Src\Controller;

use Src\TableGateways\PersonGateway;

class PersonController
{
    private $db, $requestMethod, $userId, $personGateway;

    public function __construct($db, $requestMethod, $userId)
    {
        $this->db = $db;
        $this->requestMethod = $requestMethod;
        $this->userId = $userId;
        $this->personGateway = new PersonGateway($db);
    }

    public function processRequest()
    {
        switch ($this->requestMethod) {
            case "GET":
                if ($this->userId == null) {
                    $response = $this->index();
                } else {
                    $response = $this->show($this->userId);
                }
                break;
            case "POST":
                $response = $this->store();
                break;
            case "PUT":
                $response = $this->update($this->userId);
                break;
            case "DELETE":
                $response = $this->delete($this->userId);
                break;
            default:
                $response = $this->notFoundResponse();
        }

        header($response['status_code_header']);
        if ($response['body']) {
            echo $response['body'];
        }
    }

    public function index()
    {
        $result = $this->personGateway->findAll();
        $response['status_code_header'] = "HTTP/1.1 200 OK";
        $response['body'] = json_encode($result);
        return $response;
    }

    public function show($id)
    {
        $result = $this->personGateway->find($id);
        if (!$result) {
            return $this->notFoundResponse();
        }
        $response['status_code_header'] = "HTTP/1.1 200 OK";
        $response['body'] = json_encode($result);
        return $response;
    }

    public function store()
    {
        $input = (array)json_decode(file_get_contents('php://input'), TRUE);
        if (!$this->validate($input)) {
            return $this->unprocessableEntityResponse();
        }
        $this->personGateway->insert($input);
        $response['status_code_header'] = 'HTTP/1.1 201 Created';
        $response['body'] = null;
        return $response;
    }

    public function update($id)
    {
        $result = $this->personGateway->find($id);
        if (!$result) {
            return $this->notFoundResponse();
        }
        $input = (array) json_decode(file_get_contents('php://input'), TRUE);
        if (!$this->validate($input)) {
            return $this->unprocessableEntityResponse();
        }
        $this->personGateway->update($id, $input);
        $response['status_code_header'] = 'HTTP/1.1 200 OK';
        $response['body'] = null;
        return $response;
    }

    public function delete($id)
    {
        $result = $this->personGateway->find($id);
        if (!$result) {
            return $this->notFoundResponse();
        }

        $this->personGateway->delete($id);

        $response['status_code_header'] = 'HTTP/1.1 200 OK';
        $response['body'] = null;
        return $response;
    }

    public function validate($input)
    {
        if (empty($input['firstname']))
            return false;
        if (empty($input['lastname']))
            return false;

        return true;
    }

    private function unprocessableEntityResponse()
    {
        $response['status_code_header'] = 'HTTP/1.1 422 Unprocessable Entity';
        $response['body'] = json_encode([
            'error' => 'Invalid input'
        ]);
        return $response;
    }

    private function notFoundResponse()
    {
        $response['status_code_header'] = 'HTTP/1.1 404 Not Found';
        $response['body'] = null;
        return $response;
    }
}
