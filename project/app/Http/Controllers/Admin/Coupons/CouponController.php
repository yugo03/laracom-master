<?php

namespace App\Http\Controllers\Admin\Coupons;

use App\Http\Controllers\Controller;
use App\Shop\Coupons\Repositories\CouponRepository;
use App\Shop\Coupons\Repositories\CouponRepositoryInterface;
use App\Shop\Coupons\Requests\CreateCouponRequest;
use App\Shop\Coupons\Requests\UpdateCouponRequest;

class CouponController extends Controller
{
    /**
     * @var CouponRepositoryInterface
     */
    private $couponRepo;

    /**
     * CouponController constructor.
     *
     * @param CouponRepositoryInterface $couponRepository
     */
    public function __construct(CouponRepositoryInterface $couponRepository)
    {
        $this->couponRepo = $couponRepository;
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        $data = $this->couponRepo->paginateArrayResults($this->couponRepo->listCoupons()->all());

        return view('admin.coupons.list', ['coupons' => $data]);
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function create()
    {
        return view('admin.coupons.create');
    }

    /**
     * @param CreateCouponRequest $request
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(CreateCouponRequest $request)
    {
        $data = $request->all();
        $data['is_active'] = $request->has('is_active');

        $this->couponRepo->createCoupon($data);

        return redirect()->route('admin.coupons.index')->with('message', 'Create coupon successful!');
    }

    /**
     * @param $id
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function edit($id)
    {
        return view('admin.coupons.edit', ['coupon' => $this->couponRepo->findCouponById($id)]);
    }

    /**
     * @param UpdateCouponRequest $request
     * @param $id
     *
     * @return \Illuminate\Http\RedirectResponse
     * @throws \App\Shop\Coupons\Exceptions\UpdateCouponErrorException
     */
    public function update(UpdateCouponRequest $request, $id)
    {
        $coupon = $this->couponRepo->findCouponById($id);

        $data = $request->all();
        $data['is_active'] = $request->has('is_active');

        $couponRepo = new CouponRepository($coupon);
        $couponRepo->updateCoupon($data);

        return redirect()->route('admin.coupons.edit', $id)->with('message', 'Update successful!');
    }

    /**
     * @param $id
     *
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Exception
     */
    public function destroy($id)
    {
        $coupon = $this->couponRepo->findCouponById($id);

        $couponRepo = new CouponRepository($coupon);
        $couponRepo->deleteCoupon();

        return redirect()->route('admin.coupons.index')->with('message', 'Delete successful!');
    }
}
