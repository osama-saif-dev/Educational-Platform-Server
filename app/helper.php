<?php

function alertMessage($data = '',$message = '',$status)
{
    return response()->json(
        [
            'data'          => $data,
            'message'       => $message,
            'status'        => $status,
        ]);
}
