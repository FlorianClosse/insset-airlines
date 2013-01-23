<?php
class Ffiltre1drh extends Zend_Form
{
    public function init()
    {
        /* Parametrer le formulaire */
        $this->setMethod('post')->setAction('/drh/filtre/id/0');
        $this->setAttrib('id', 'FormFiltre1Drh');

        $aeroport = new Aeroport;
        $lesAeroport = $aeroport->fetchAll();
        $aeroport = new Zend_Form_Element_Select('aeroport');
        $aeroport ->setLabel('Choisir un aeroport');
        foreach ($lesAeroport as $unAeroport ) {
            $tableauAeroport[$unAeroport -> idAeroport] = ucfirst($unAeroport->nomAeroport);
        } // permet de construite mes données de mon select

        $aeroport->setMultiOptions($tableauAeroport); // remplit ma liste deroulante
        $aeroport->setAttrib('id', 'listederoulanteajout');

        $heuremax = new Zend_Form_Element_Text('heuremax');
        $heuremax ->setLabel('Choix optionnel : Choisir un minimum d\heure de vol');
        $heuremax -> autocomplete = 'off';
        $heuremax->setAttrib('id', '$heuremax');

        $pSubmit = new Zend_Form_Element_Submit('Filtrer');
        $pSubmit->setAttrib('id', 'filtre1');

        $this->addElement($aeroport);
        $this->addElement($heuremax);
        $this->addElement($pSubmit);
    }
}