<div
	x-data
	x-init="() => {
	var choices = new Choices($refs.{{ $attributes['prettyname'] }}, {
		itemSelectText: '',
		removeItems: true,
        removeItemButton: true,
        maxItemCount:{!! $attributes['max'] !!},
        maxItemText: (maxItemCount) => {
            return `Only ${maxItemCount} Relievers can be added`;
          },
	});
	choices.passedElement.element.addEventListener(
	  'change',
	  function(event) {
	  		values = getSelectValues($refs.{{ $attributes['prettyname'] }});
		    @this.set('{{ $attributes['wire:model'] }}', values);
            Livewire.emit('selectChanged');
	  },
	  false,
	);

	items = {!! $attributes['selected'] !!};
	if(Array.isArray(items)){
		items.forEach(function(select) {
            console.log(select);
			choices.setChoiceByValue((select).toString());
		});
	}
	}
	function getSelectValues(select) {
	  var result = [];
	  var options = select && select.options;
	  var opt;
	  for (var i=0, iLen=options.length; i<iLen; i++) {
	    opt = options[i];
	    if (opt.selected) {
	      result.push(opt.value || opt.text);
	    }
	  }
	  return result;
	}
    ">
    <select id="{{ $attributes['prettyname'] }}" wire-model="{{ $attributes['wire:model'] }}" wire:change="{{ $attributes['wire:change'] }}" x-ref="{{ $attributes['prettyname'] }}" multiple="multiple">
    	@if(count($attributes['options'])>0)
	    	@foreach($attributes['options'] as $key=>$option)
	    		<option value="{{$key}}" >{{$option}}</option>
	    	@endforeach
    	@endif
    </select>
</div>
