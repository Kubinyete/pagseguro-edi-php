<?php

namespace Kubinyete\Edi\PagSeguro\Core;

use Throwable;
use DateTimeInterface;
use Psr\Log\LoggerInterface;
use Kubinyete\Edi\PagSeguro\Http\Response;
use Kubinyete\Edi\PagSeguro\IO\JsonSerializer;
use Kubinyete\Edi\PagSeguro\Core\Misc\Paginator;
use Kubinyete\Edi\PagSeguro\Exception\HttpException;
use Kubinyete\Edi\PagSeguro\Model\Movement\Pagination;
use Kubinyete\Edi\PagSeguro\Model\Token\TokenResponse;
use Kubinyete\Edi\PagSeguro\Http\Client\GuzzleHttpClient;
use Kubinyete\Edi\PagSeguro\Model\Pagination\FinantialPage;
use Kubinyete\Edi\PagSeguro\Model\Movement\FinantialMovement;
use Kubinyete\Edi\PagSeguro\Model\Error\PagSeguroRequestError;
use Kubinyete\Edi\PagSeguro\Model\Pagination\AnticipationPage;
use Kubinyete\Edi\PagSeguro\Model\Pagination\TransactionalPage;
use Kubinyete\Edi\PagSeguro\Model\Movement\AnticipationMovement;
use Kubinyete\Edi\PagSeguro\Model\Movement\TransactionalMovement;
use Kubinyete\Edi\PagSeguro\Core\Misc\TransactionalMovementPaginator;
use Kubinyete\Edi\PagSeguro\Exception\PagSeguro\PagSeguroHttpException;

class PagSeguroEdiClient extends Client
{
    public const VERSION_100 = '1.00';
    public const VERSION_200 = '2.00';
    public const VERSION_201 = '2.01';
    public const VERSION_LATEST = self::VERSION_201;

    public const MOVEMENT_TRANSACTIONAL = 1;
    public const MOVEMENT_FINANTIAL = 2;
    public const MOVEMENT_ANTICIPATION = 3;

    public function __construct(
        PagSeguroEdiEnvironment $env,
        private string $clientId,
        private string $token,
        private string $version = self::VERSION_LATEST,
        ?LoggerInterface $logger = null
    ) {
        parent::__construct(
            $env,
            new GuzzleHttpClient([
                'headers' => [
                    'User-Agent' => 'PagSeguroEdiClient for PHP (kubinyete/pagseguro-edi)'
                ],
            ]),
            new JsonSerializer(),
            $logger
        );
    }

    public function verifyTokenAccess(): TokenResponse
    {
        return TokenResponse::parse($this->get("/users/{$this->clientId}/token/{$this->token}")->getParsed());
    }

    protected function fetchMovementPage(DateTimeInterface $date, int $type, int $page, int $pageSize = 100): Response
    {
        return $this->get("/{$this->version}/movimentos", [
            'dataMovimento' => $date->format('Y-m-d'),
            'tipoMovimento' => $type,
            'pageSize' => $pageSize,
            'pageNumber' => $page,
        ], ['Authorization' => 'Basic ' . base64_encode("{$this->clientId}:{$this->token}")]);
    }

    public function fetchTransactionalPage(DateTimeInterface $date, int $page, int $pageSize = 100): Response
    {
        return $this->fetchMovementPage($date, self::MOVEMENT_TRANSACTIONAL, $page, $pageSize);
    }

    public function getTransactionalPage(DateTimeInterface $date, int $page, int $pageSize = 100): TransactionalPage
    {
        return TransactionalPage::parse($this->fetchTransactionalPage($date, $page, $pageSize)->getParsed());
    }

    public function fetchFinantialPage(DateTimeInterface $date, int $page, int $pageSize = 100): Response
    {
        return $this->fetchMovementPage($date, self::MOVEMENT_FINANTIAL, $page, $pageSize);
    }

    public function getFinantialPage(DateTimeInterface $date, int $page, int $pageSize = 100): FinantialPage
    {
        return FinantialPage::parse($this->fetchFinantialPage($date, $page, $pageSize)->getParsed());
    }

    public function fetchAnticipationPage(DateTimeInterface $date, int $page, int $pageSize = 100): Response
    {
        return $this->fetchMovementPage($date, self::MOVEMENT_ANTICIPATION, $page, $pageSize);
    }

    public function getAnticipationPage(DateTimeInterface $date, int $page, int $pageSize = 100): AnticipationPage
    {
        return AnticipationPage::parse($this->fetchAnticipationPage($date, $page, $pageSize)->getParsed());
    }

    //

    /**
     * Returns a Paginator object for sequential reading over every transactional movement specified
     *
     * @param DateTimeInterface $date
     * @param integer $pageSize
     * @return Paginator<TransactionalMovement>
     */
    public function getTransactionalMovements(DateTimeInterface $date, int $pageSize = 100): Paginator
    {
        return new Paginator(function (int $page, int $size, callable $limiter) use ($date) {
            $parsed = $this->getTransactionalPage($date, $page, $size);
            $limiter($parsed->getPagination()->getTotalPages());
            return $parsed->getDetails();
        }, 1, $pageSize);
    }

    /**
     * Returns a Paginator object for sequential reading over every finantial movement specified
     *
     * @param DateTimeInterface $date
     * @param integer $pageSize
     * @return Paginator<FinantialMovement>
     */
    public function getFinantialMovements(DateTimeInterface $date, int $pageSize = 100): Paginator
    {
        return new Paginator(function (int $page, int $size, callable $limiter) use ($date) {
            $parsed = $this->getFinantialPage($date, $page, $size);
            $limiter($parsed->getPagination()->getTotalPages());
            return $parsed->getDetails();
        }, 1, $pageSize);
    }

    /**
     * Returns a Paginator object for sequential reading over every anticipation movement specified
     *
     * @param DateTimeInterface $date
     * @param integer $pageSize
     * @return Paginator<AnticipationMovement>
     */
    public function getAnticipationMovements(DateTimeInterface $date, int $pageSize = 100): Paginator
    {
        return new Paginator(function (int $page, int $size, callable $limiter) use ($date) {
            $parsed = $this->getAnticipationPage($date, $page, $size);
            $limiter($parsed->getPagination()->getTotalPages());
            return $parsed->getDetails();
        }, 1, $pageSize);
    }
}
