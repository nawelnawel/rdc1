<?php

namespace App\Http\Livewire;

use App\Models\Categorie;
use App\Models\Marque;
use Illuminate\Validation\Rule;
use Livewire\Component;
use Livewire\WithPagination;


class Marques extends Component
{
    use WithPagination;
    protected $paginationTheme="bootstrap";
    
    
    public $isBtnAddMarqueClicked=false;
    public $isBtnEditMarqueClicked=false;
    public $newMarq = [];
    public $editMarq = [];

    public function rules(){
        if($this->isBtnEditMarqueClicked){

   return [ 

   'editMarq.nom' =>['required', Rule::unique("marques", "nom")->ignore($this->editMarq['id'])],
   'editMarq.categorie_id' =>'required',
 

  ];
 }
  return [ 

    'newMarq.nom' =>'required|unique:marques,nom',
    'newMarq.categorie_id' =>'required',
    
 
  ];

    }





    public function render()
    {
        return view('livewire.marques.index',[
            "categories"=>Categorie::all(),
            "marques"=> Marque::latest()->paginate(4)
        ]) 
        ->extends("layout.master")
        ->section("contenu");
    }

    public function goToAddMar(){
      
        $this->isBtnAddMarqueClicked=true;
    }
    //renvoi la page edit 
    public function goToEditMarq($id){
        $this->editMarq=Marque::find($id)->toArray();
       
          $this->isBtnEditMarqueClicked=true;
      }




    public function goToListMarq(){
        $this->isBtnAddMarqueClicked=false;
        $this->isBtnEditMarqueClicked=false;
    }


   //fct de modification lot 
   public function updateMarq(){
     
    // Vérifier que les informations envoyées par le formulaire sont correctes
    $validationAttributes = $this->validate();


    Marque::find($this->editMarq["id"])->update($validationAttributes["editMarq"]);

    $this->dispatchBrowserEvent("showSuccessMessage", ["message"=>"Marque mis à jour avec succès!"]);
}


    public function addMarq(){
         //vérifier les information envoyée  ask correctes
         $validationAttributes = $this->validate();
    

         //ajouter un nouvel utilisateur
         Marque::create($validationAttributes["newMarq"]);
     
         
        $this->newMarq=[];
        $this->dispatchBrowserEvent("showSuccessMessage",["message"=>"MARQUE cree avec succés!"]);
     }

     public function confirmDelete($name, $id){
        $this->dispatchBrowserEvent("showConfirmMessage",[ "message"=> [
 "text" => "vous etes sur le point de supprimer la MARQUE $name  ! ,",
"title"=> 'Etes-vous sur de continuer ?',
"type"=>"warning",
 "data"=> [ "marqid"=> $id ],
    
    
         ] ]);  
    }

public function deleteMarq($id){
    Marque::destroy($id);
    $this->dispatchBrowserEvent("showSuccessMessage",["message"=>"Marque supprimee avec succés!"]);
}

}
