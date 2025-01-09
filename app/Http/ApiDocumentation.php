<?php
namespace App\Http;

use OpenApi\Annotations as OA;

/**
 * @OA\Info(
 *     title="Simple Blog API",
 *     version="1.0.0",
 *     description="This is a sample API for managing posts",
 *     @OA\Contact(email="afurlongla@gmail.com"),
 *     @OA\License(name="MIT", url="https://opensource.org/licenses/MIT")
 * )
 *
 * @OA\SecurityScheme(
 *     securityScheme="BearerAuth",
 *     type="http",
 *     scheme="bearer",
 *     bearerFormat="JWT"
 * )
 */
class ApiDocumentation
{
}
