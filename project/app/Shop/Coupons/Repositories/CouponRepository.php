<?php

namespace App\Shop\Coupons\Repositories;

use Jsdecena\Baserepo\BaseRepository;
use App\Shop\Coupons\Coupon;
use App\Shop\Coupons\Exceptions\CouponNotFoundException;
use App\Shop\Coupons\Exceptions\CreateCouponErrorException;
use App\Shop\Coupons\Exceptions\UpdateCouponErrorException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Database\QueryException;
use Illuminate\Support\Collection;

class CouponRepository extends BaseRepository implements CouponRepositoryInterface
{
    /**
     * CouponRepository constructor.
     *
     * @param Coupon $coupon
     */
    public function __construct(Coupon $coupon)
    {
        parent::__construct($coupon);
        $this->model = $coupon;
    }

    /**
     * @param array $data
     *
     * @return Coupon
     * @throws CreateCouponErrorException
     */
    public function createCoupon(array $data) : Coupon
    {
        try {
            return $this->create($data);
        } catch (QueryException $e) {
            throw new CreateCouponErrorException($e);
        }
    }

    /**
     * @param int $id
     *
     * @return Coupon
     * @throws CouponNotFoundException
     */
    public function findCouponById(int $id) : Coupon
    {
        try {
            return $this->findOneOrFail($id);
        } catch (ModelNotFoundException $e) {
            throw new CouponNotFoundException($e->getMessage());
        }
    }

    /**
     * @param string $code
     *
     * @return Coupon
     * @throws CouponNotFoundException
     */
    public function findCouponByCode(string $code) : Coupon
    {
        try {
            return $this->findOneByOrFail(['code' => $code]);
        } catch (ModelNotFoundException $e) {
            throw new CouponNotFoundException("The coupon \"{$code}\" does not exist.");
        }
    }

    /**
     * @param array $data
     *
     * @return bool
     * @throws UpdateCouponErrorException
     */
    public function updateCoupon(array $data) : bool
    {
        try {
            return $this->update($data);
        } catch (QueryException $e) {
            throw new UpdateCouponErrorException($e);
        }
    }

    /**
     * @return bool
     * @throws \Exception
     */
    public function deleteCoupon() : bool
    {
        return $this->delete();
    }

    /**
     * @param array $columns
     * @param string $orderBy
     * @param string $sortBy
     *
     * @return Collection
     */
    public function listCoupons($columns = array('*'), string $orderBy = 'id', string $sortBy = 'desc') : Collection
    {
        return $this->all($columns, $orderBy, $sortBy);
    }
}
