<?php

namespace Grimarina\CityBike\Actions\Trips;

use Grimarina\CityBike\http\{ErrorResponse, Request, Response, SuccessfulResponse};
use Grimarina\CityBike\Repositories\TripsRepository;
use Grimarina\CityBike\Exceptions\{TripNotFoundException, HttpException};
use Grimarina\CityBike\Actions\ActionInterface;

class FindAllTrips implements ActionInterface
{
    public function __construct(
        private TripsRepository $tripsRepository
    ) {
    }

    public function handle(Request $request): Response
    {
        try {
            $page = $request->query('page');
            $page = ($page > 0) ? $page : 1;
        } catch (HttpException $e) {
            return new ErrorResponse($e->getMessage());
        }

        try {
            $trips = $this->tripsRepository->getAll($page);
            return new SuccessfulResponse($trips);
        } catch (TripNotFoundException $e) {
            return new ErrorResponse($e->getMessage());
        }
    }
}