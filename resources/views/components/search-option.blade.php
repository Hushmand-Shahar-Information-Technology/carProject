@props(['name', 'label', 'options'])
 
 <div class="col-xl-2 col-md-4 col-sm-6">
        <div class="selected-box">
            <select class="selectpicker" name="{{$name}}">
                <option>{{$label}}</option>
                    @foreach ($options as $item)
                        <option value="{{$item}}">{{$item}}</option>
                    @endforeach
            </select>
        </div>
</div>