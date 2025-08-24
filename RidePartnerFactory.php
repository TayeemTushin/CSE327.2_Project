<?php
require_once 'CarPartner.php';
require_once 'CngPartner.php';

class RidePartnerFactory {
    public function getPartner($type) {
        switch (strtolower($type)) {
            case 'car':
                return new CarPartner();
            case 'cng':
                return new CngPartner();
            default:
                return null;
        }
    }
    
    public function getAvailableTypes() {
        return ['car', 'cng'];
    }
    
    public function getAllPartners() {
        $partners = [];
        foreach ($this->getAvailableTypes() as $type) {
            $partners[$type] = $this->getPartner($type);
        }
        return $partners;
    }
}
?>