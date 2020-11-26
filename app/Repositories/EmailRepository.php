<?php

namespace App\Repositories;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Http\Request;
use GuzzleHttp\Client;

class EmailRepository
{
    public function sendEmail($remitentes,$nombre_correo,$asunto,$cuerpo){
        $temp = explode(',',$remitentes);
        $email = [];

        foreach($temp as $clave => $t){
            $email[] = [
                "email" => $t
            ];
        }

        $dataSend = [
            'name' => $nombre_correo,
            'emails' => $email,
            'subject' => $asunto,
            'content' => "<p>".$cuerpo."</p>",
            'type' => 'regular',
            'language' => 'es',
            'from' => 'noreply@brm.com.co',
            'from_name' => 'BRM S.A'
        ];

        $token = 'eyJ0eXAiOiJKV1QiLCJhbGciOiJSUzI1NlIsImp0aSI6ImY0NjZjYzlkNzA5YTk1YjE2ZDkxMzVhYjczMzQxY2M5YzVlNGNjZjhjYTU0NGI0YWQ5NzExOGY5ZGMzNGFjNTlhNmU0YmM2MjQxMzIyNzdjIn0.eyJhdWQiOiIxIiwianRpIjoiZjQ2NmNjOWQ3MDlhOTViMTZkOTEzNWFiNzMzNDFjYzljNWU0Y2NmOGNhNTQ0YjRhZDk3MTE4ZjlkYzM0YWM1OWE2ZTRiYzYyNDEzMjI3N2MiLCJpYXQiOjE1ODgwMDYyNzEsIm5iZiI6MTU4ODAwNjI3MSwiZXhwIjoxNjE5NTQyMjcwLCJzdWIiOiIxIiwic2NvcGVzIjpbXX0.Z8zurXFWbrYidobQcuOf_ji7c3T0opneVU1oq98r8rWyNS2qpjkiEgvFgsg2yjx7CkdIUi96Ehw1MkNcnJLwdS0s_9amkQnKzLVAwpWmYKmhNriHXVfh4MxarPtmBwc3mRGD0r1SkX1GH68BHt1L9Dws3lWZfarCapH5snr9Rh7Ii7GOrxNT18MwghmU3-c7wwkWshxJy5QQo6l3kFptgrYaxyF5_QZhaxAXGfNH_JCS-qaOBic6wLDV-cIsemb9PmDW_iZf07WxNYZFVQweYICqqiPheF-_KEmXsRbQqOMRJl-mtatlGcfXK4BmJZL6UesZ_U13JWV8lqAH62YhFFs25o1axhN-PMx_7R6rF-8gLdO7yqKyozHwTYIeOeNFYBL3iDzjJWSQ5CxvT2mZ8IXwtYaTahlXSD2WpWQO5oyN8oULQEx2HbSfq-e-ZlFZu6l2DfdblLoFtxOVEehXrw6woGawWfEqmWJb8AZGPTTImoludGU8okeMjUhaQF98guS6ct9EbrjOSe5DeHg-SXn7Lw8axKe6HlZlz_7EjYeVedfxg-j0xDoXkHe-xhYv0N4-kz9cpLk7-ItG2RsvmmryqASl5THx4AlrX2Bqt0W2IAOmP4mindIWNnT62-OGbY7HSfYq7mOFFCr3Fkpp9UuEfXiL0dwVCdPKs9c';
        
        $headers = [
            'Authorization' => $token,
            'Content-Type' => 'application/json'
        ];

        $client = new Client([
            'base_uri' => 'https://duvapi.tars.dev/',
            'timeout' => 10.0
        ]);

        $response = json_decode($client->post('mind/mailerLite/sendMasive', [
            'headers' => $headers,
            'json' => $dataSend,
            'http_errors' => false
        ])->getBody());
    }
}