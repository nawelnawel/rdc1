<?php

namespace App\Http\Livewire;

use App\Models\Lot;
use App\Models\Materiel;
use Illuminate\Validation\Rule;
use Livewire\Component;
use Livewire\WithPagination;

class Materiels extends Component
{
    use WithPagination;
    protected $paginationTheme="bootstrap";

   public $isBtnAddMaterielClicked=false;

   public $editMateriel=[];
   public $newMateriel=[];

   public $isBtnEditMaterielClicked=false;


   public function rules(){
    if($this->isBtnEditMaterielClicked){

return [ 

'editMateriel.num_serie' =>['required', Rule::unique("materiels", "num_serie")->ignore($this->editMateriel['id'])],
'editMateriel.codebarre' =>['required', Rule::unique("materiels", "codebarre")->ignore($this->editMateriel['id'])],
'editMateriel.nom' =>'string',
'editMateriel.etat' =>'required|string',
'editMateriel.affectation' =>'boolean',

'editMateriel.lot_id' =>'required',


];
}
return [ 

    'newMateriel.num_serie' =>'required',
    'newMateriel.codebarre' =>'required',
    'newMateriel.nom' =>'string',
    'newMateriel.etat' =>'required|string',
    'newMateriel.affectation' =>'boolean',
    
    'newMateriel.lot_id' =>'required',


];

}








    public function render()
    {
        return view('livewire.materiels.index',[
            "lots"=> Lot::all(), 
            
            "materiels"=> Materiel::latest()->paginate(4)
        ]) 
        ->extends("layout.master")
        ->section("contenu");
    }
    


     //renvoie la page create
     public function goToAddMateriel(){
        $this->isBtnAddMaterielClicked=true;

    }

    public function goToEditMateriel($id){
        $this->editMateriel=Materiel::find($id)->toArray();
        $this->isBtnEditMaterielClicked=true;

    }
//renvoi la page liste
  public function goToListMateriel(){
    $this->isBtnEditMaterielClicked=false;
      $this->isBtnAddMaterielClicked=false;
  }


   //fct dajout de lot 
   public function addMateriel(){
   
        // Vérifier que les informations envoyées par le formulaire sont correctes
        $validationAttributes = $this->validate();


        Materiel::create($validationAttributes["newMateriel"]);

      $this->newMateriel=[];
      $this->dispatchBrowserEvent("showSuccessMessage",["message"=>"Materiel cree avec succés!"]);
   }



    //fct de modification lot 
    public function updateMateriel(){
     
        // Vérifier que les informations envoyées par le formulaire sont correctes
        $validationAttributes = $this->validate();


        Materiel::find($this->editMateriel["id"])->update($validationAttributes["editMateriel"]);

        $this->dispatchBrowserEvent("showSuccessMessage", ["message"=>"Materiel mis à jour avec succès!"]);
    }





//suppression lot 
public function confirmDelete($name, $id){
    $this->dispatchBrowserEvent("showConfirmMessage",[ "message"=> [
"text" => "vous etes sur le point de supprimer le Materiel $name  ! ,",
"title"=> 'Etes-vous sur de continuer ?',
"type"=>"warning",
"data"=> [ "materielid"=> $id ],


     ] ]);  
}

public function deleteMateriel($id){
Materiel::destroy($id);
$this->dispatchBrowserEvent("showSuccessMessage",["message"=>"Materiel supprimee avec succés!"]);
}





}