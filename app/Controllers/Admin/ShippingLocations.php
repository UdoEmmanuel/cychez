<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\ShippingZoneModel;
use App\Models\ShippingLocationModel;
use Config\NigerianStates;

class ShippingLocations extends BaseController
{
    protected $zoneModel;
    protected $locationModel;

    public function __construct()
    {
        $this->zoneModel = new ShippingZoneModel();
        $this->locationModel = new ShippingLocationModel();
    }

    /**
     * List locations for a zone
     */
    public function index($zoneId)
    {
        $zone = $this->zoneModel->find($zoneId);

        if (!$zone) {
            session()->setFlashdata('error', 'Zone not found');
            return redirect()->to('admin/shipping-zones');
        }

        $data = [
            'title' => 'Manage Locations - ' . $zone['zone_name'],
            'zone' => $zone,
            'locations' => $this->locationModel->getByZone($zoneId),
        ];

        return view('admin/shipping/locations/index', $data);
    }

    /**
     * Create location form
     */
    public function create($zoneId)
    {
        $zone = $this->zoneModel->find($zoneId);

        if (!$zone) {
            session()->setFlashdata('error', 'Zone not found');
            return redirect()->to('admin/shipping-zones');
        }

        $data = [
            'title' => 'Add Location - ' . $zone['zone_name'],
            'zone' => $zone,
            'states' => NigerianStates::all(),
        ];

        return view('admin/shipping/locations/create', $data);
    }

    /**
     * Store location
     */
    public function store($zoneId)
    {
        $zone = $this->zoneModel->find($zoneId);

        if (!$zone) {
            session()->setFlashdata('error', 'Zone not found');
            return redirect()->to('admin/shipping-zones');
        }

        $rules = [
            'state' => 'required|min_length[3]',
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()
                ->withInput()
                ->with('errors', $this->validator->getErrors());
        }

        $state = $this->request->getPost('state');
        $city = $this->request->getPost('city') ?: null;
        $area = $this->request->getPost('area') ?: null;

        // Check if location already exists
        if ($this->locationModel->locationExists($zoneId, $state, $city, $area)) {
            session()->setFlashdata('error', 'This location already exists for this zone');
            return redirect()->back()->withInput();
        }

        $data = [
            'zone_id' => $zoneId,
            'state' => $state,
            'city' => $city,
            'area' => $area,
        ];

        if ($this->locationModel->insert($data)) {
            session()->setFlashdata('success', 'Location added successfully');
            return redirect()->to("admin/shipping-zones/{$zoneId}/locations");
        }

        session()->setFlashdata('error', 'Failed to add location');
        return redirect()->back()->withInput();
    }

    /**
     * Delete location
     */
    public function delete($zoneId, $locationId)
    {
        $location = $this->locationModel->find($locationId);

        if (!$location || $location['zone_id'] != $zoneId) {
            session()->setFlashdata('error', 'Location not found');
            return redirect()->to("admin/shipping-zones/{$zoneId}/locations");
        }

        if ($this->locationModel->delete($locationId)) {
            session()->setFlashdata('success', 'Location deleted successfully');
        } else {
            session()->setFlashdata('error', 'Failed to delete location');
        }

        return redirect()->to("admin/shipping-zones/{$zoneId}/locations");
    }

    /**
     * Bulk add locations
     */
    public function bulkCreate($zoneId)
    {
        $zone = $this->zoneModel->find($zoneId);

        if (!$zone) {
            session()->setFlashdata('error', 'Zone not found');
            return redirect()->to('admin/shipping-zones');
        }

        $data = [
            'title' => 'Bulk Add Locations - ' . $zone['zone_name'],
            'zone' => $zone,
            'states' => NigerianStates::all(),
        ];

        return view('admin/shipping/locations/bulk_create', $data);
    }

    /**
     * Store bulk locations
     */
    public function bulkStore($zoneId)
    {
        $zone = $this->zoneModel->find($zoneId);

        if (!$zone) {
            session()->setFlashdata('error', 'Zone not found');
            return redirect()->to('admin/shipping-zones');
        }

        $locationsData = $this->request->getPost('locations');

        if (empty($locationsData)) {
            session()->setFlashdata('error', 'No locations provided');
            return redirect()->back();
        }

        $locations = [];
        $errors = [];

        foreach ($locationsData as $index => $locationData) {
            if (empty($locationData['state'])) {
                continue;
            }

            $state = $locationData['state'];
            $city = $locationData['city'] ?: null;
            $area = $locationData['area'] ?: null;

            // Check for duplicates
            if ($this->locationModel->locationExists($zoneId, $state, $city, $area)) {
                $errors[] = "Row " . ($index + 1) . ": Location already exists";
                continue;
            }

            $locations[] = [
                'state' => $state,
                'city' => $city,
                'area' => $area,
            ];
        }

        if (empty($locations)) {
            session()->setFlashdata('error', 'No valid locations to add. ' . implode(', ', $errors));
            return redirect()->back();
        }

        if ($this->locationModel->addBulkLocations($zoneId, $locations)) {
            $message = count($locations) . ' location(s) added successfully';
            if (!empty($errors)) {
                $message .= '. Skipped: ' . implode(', ', $errors);
            }
            session()->setFlashdata('success', $message);
            return redirect()->to("admin/shipping-zones/{$zoneId}/locations");
        }

        session()->setFlashdata('error', 'Failed to add locations');
        return redirect()->back();
    }
}