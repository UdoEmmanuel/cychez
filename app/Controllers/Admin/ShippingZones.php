<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\ShippingZoneModel;
use App\Models\ShippingLocationModel;

class ShippingZones extends BaseController
{
    protected $zoneModel;
    protected $locationModel;

    public function __construct()
    {
        $this->zoneModel = new ShippingZoneModel();
        $this->locationModel = new ShippingLocationModel();
    }

    /**
     * List all shipping zones
     */
    public function index()
    {
        $data = [
            'title' => 'Shipping Zones - Admin',
            'zones' => $this->zoneModel->orderBy('priority', 'ASC')->findAll(),
            'stats' => $this->zoneModel->getStatistics(),
        ];

        return view('admin/shipping/zones/index', $data);
    }

    /**
     * Create new zone form
     */
    public function create()
    {
        $data = [
            'title' => 'Create Shipping Zone - Admin',
        ];

        return view('admin/shipping/zones/create', $data);
    }

    /**
     * Store new zone
     */
    public function store()
    {
        $rules = [
            'zone_name' => 'required|min_length[3]|max_length[100]',
            'base_fee' => 'required|decimal|greater_than_equal_to[0]',
            'priority' => 'required|integer|greater_than_equal_to[1]',
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()
                ->withInput()
                ->with('errors', $this->validator->getErrors());
        }

        $data = [
            'zone_name' => $this->request->getPost('zone_name'),
            'base_fee' => $this->request->getPost('base_fee'),
            'priority' => $this->request->getPost('priority'),
            'is_active' => $this->request->getPost('is_active') ? 1 : 0,
            'description' => $this->request->getPost('description'),
        ];

        if ($this->zoneModel->insert($data)) {
            session()->setFlashdata('success', 'Shipping zone created successfully');
            return redirect()->to('admin/shipping-zones');
        }

        session()->setFlashdata('error', 'Failed to create shipping zone');
        return redirect()->back()->withInput();
    }

    /**
     * Edit zone form
     */
    public function edit($id)
    {
        $zone = $this->zoneModel->getZoneWithLocations($id);

        if (!$zone) {
            session()->setFlashdata('error', 'Zone not found');
            return redirect()->to('admin/shipping-zones');
        }

        $data = [
            'title' => 'Edit Shipping Zone - Admin',
            'zone' => $zone,
        ];

        return view('admin/shipping/zones/edit', $data);
    }

    /**
     * Update zone
     */
    public function update($id)
    {
        $zone = $this->zoneModel->find($id);

        if (!$zone) {
            session()->setFlashdata('error', 'Zone not found');
            return redirect()->to('admin/shipping-zones');
        }

        $rules = [
            'zone_name' => 'required|min_length[3]|max_length[100]',
            'base_fee' => 'required|decimal|greater_than_equal_to[0]',
            'priority' => 'required|integer|greater_than_equal_to[1]',
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()
                ->withInput()
                ->with('errors', $this->validator->getErrors());
        }

        $data = [
            'zone_name' => $this->request->getPost('zone_name'),
            'base_fee' => $this->request->getPost('base_fee'),
            'priority' => $this->request->getPost('priority'),
            'is_active' => $this->request->getPost('is_active') ? 1 : 0,
            'description' => $this->request->getPost('description'),
        ];

        if ($this->zoneModel->update($id, $data)) {
            session()->setFlashdata('success', 'Shipping zone updated successfully');
            return redirect()->to('admin/shipping-zones');
        }

        session()->setFlashdata('error', 'Failed to update shipping zone');
        return redirect()->back()->withInput();
    }

    /**
     * Toggle zone active status
     */
    public function toggleActive($id)
    {
        if ($this->zoneModel->toggleActive($id)) {
            session()->setFlashdata('success', 'Zone status updated');
        } else {
            session()->setFlashdata('error', 'Failed to update zone status');
        }

        return redirect()->to('admin/shipping-zones');
    }

    /**
     * Delete zone
     */
    public function delete($id)
    {
        $zone = $this->zoneModel->find($id);

        if (!$zone) {
            session()->setFlashdata('error', 'Zone not found');
            return redirect()->to('admin/shipping-zones');
        }

        // Check if it's the fallback zone
        if ($zone['priority'] == 999) {
            session()->setFlashdata('error', 'Cannot delete the fallback zone');
            return redirect()->to('admin/shipping-zones');
        }

        // Delete all locations first
        $this->locationModel->deleteByZone($id);

        // Delete zone
        if ($this->zoneModel->delete($id)) {
            session()->setFlashdata('success', 'Zone deleted successfully');
        } else {
            session()->setFlashdata('error', 'Failed to delete zone');
        }

        return redirect()->to('admin/shipping-zones');
    }

    /**
     * View zone details with locations
     */
    public function view($id)
    {
        $zone = $this->zoneModel->getZoneWithLocations($id);

        if (!$zone) {
            session()->setFlashdata('error', 'Zone not found');
            return redirect()->to('admin/shipping-zones');
        }

        $data = [
            'title' => 'Zone Details - Admin',
            'zone' => $zone,
        ];

        return view('admin/shipping/zones/view', $data);
    }

    /**
     * Quick update fee (AJAX)
     */
    public function updateFee()
    {
        if (!$this->request->isAJAX()) {
            return $this->response->setJSON(['success' => false, 'message' => 'Invalid request']);
        }

        $zoneId = $this->request->getPost('zone_id');
        $newFee = $this->request->getPost('new_fee');

        if ($this->zoneModel->updateFee($zoneId, $newFee)) {
            return $this->response->setJSON([
                'success' => true,
                'message' => 'Fee updated successfully',
            ]);
        }

        return $this->response->setJSON([
            'success' => false,
            'message' => 'Failed to update fee',
        ]);
    }
}