<?php

namespace App\RESTResponse;

class RESTResponse{
    protected $messageBag = array(
        200 => 'OK',
        201 => 'Created',
    );

    protected function makeResponse($httpStatus, Array $payload){
        return response()->json($payload, $httpStatus);
    }

    public function makeDataResponse($httpStatus, $data, $message = null){
        if(is_null($message)){
            $message = $this->messageBag[$httpStatus];
        }

        $payload = array(
            'status' => $httpStatus,
            'message' => $message,
            'data' => $data,
        );

        return $this->makeResponse($httpStatus, $payload);
    }

    public function makeSuccessResponse($httpStatus, $message = null){
        if(is_null($message)){
            $message = $this->messageBag[$httpStatus];
        }

        $payload = array(
            'success' => array(
                'status' => $httpStatus,
                'message' => $message,
            )
        );

        return $this->makeResponse($httpStatus, $payload);
    }

    public function makeErrorResponse($httpStatus, $messages){
        $payload = array(
            'error' => array(
                'status' => $httpStatus,
                'message' => $messages,
            )
        );

        return $this->makeResponse($httpStatus, $payload);
    }

    /*
    |--------------------------------------------------------------------------|
    |                          2xx Message Area                                |
    |--------------------------------------------------------------------------|
    */

    public function ok($message = null){
        return $this->makeSuccessResponse(200, $message);
    }

    public function created($message = null){
        return $this->makeSuccessResponse(201, $message);
    }

    /*
    |--------------------------------------------------------------------------|
    |                           4xx Error Area                                 |
    |--------------------------------------------------------------------------|
    */

    public function badRequest($messages = null){
        if(empty($messages)){
            return $this->makeErrorResponse(400, 'Bad Request');
        }else{
            return $this->makeErrorResponse(400, $messages);
        }
    }

    public function error400($messages = null){
        return $this->badRequest($messages);
    }

    public function notAuthenticated($messages = null){
        if(empty($messages)){
            return $this->makeErrorResponse(401, 'Unauthorized');
        }else{
            return $this->makeErrorResponse(401, $messages);
        }
    }

    public function error401($messages = null){
        return $this->notAuthenticated($messages);
    }

    public function notAuthorized($messages = null){
        if(empty($messages)){
            return $this->makeErrorResponse(403, 'Forbidden');
        }else{
            return $this->makeErrorResponse(403, $messages);
        }
    }

    public function error403($messages = null){
        return $this->notAuthorized($messages);
    }

    public function notFound($messages = null){
        if(empty($messages)){
            return $this->makeErrorResponse(404, 'Not Found');
        }else{
            return $this->makeErrorResponse(404, $messages);
        }
    }

    public function error404($messages = null){
        return $this->notFound($messages);
    }

    /*
    |--------------------------------------------------------------------------|
    |                           5xx Error Area                                 |
    |--------------------------------------------------------------------------|
    */

    public function serverError($messages = null){
        if(empty($messages)){
            return $this->makeErrorResponse(500, 'ISE');
        }else{
            return $this->makeErrorResponse(500, $messages);
        }
    }

    public function error500($messages = null){
        return $this->serverError($messages);
    }

}
