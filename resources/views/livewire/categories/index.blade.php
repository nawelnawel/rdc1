<div>
 
@if ($isBtnEditClicked)

@include("livewire.categories.edit")



@else

@if ($isBtnAddClicked)

@include("livewire.categories.create")


@else

@include("livewire.categories.liste")
@endif
@endif

</div>