<div class="col-lg-12 table-responsive">
    <table class="table table-bordered" id="editable">
        <thead>
            <tr>
                <th>Srno</th>
                <th>Select</th>
                <th>Name</th>
                <th>Contact no</th>
                <th>Hobbies</th>
                <th>Category</th>
                <th>Profile Pic</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            @isset($employees)
                @foreach ($employees as $employee)
                <tr>
                    <td>{{ $loop->index + 1 }}</td>
                    <td>
                        <div class="form-check">
                            <input class="form-check-input" name="employees" type="checkbox" value="{{$employee->employee_id}}" id=" 'employee' . {{$employee->employee_id}}">
                        </div>
                    </td>
                    <td>
                        <div class="{{'view_mode-' . $employee->employee_id}}">
                            {{ ucfirst($employee->name) }}
                        </div>
                        <div class="{{'form-group edit_mode edit_mode-' . $employee->employee_id}}">
                            <input type="text" class="form-control" id="{{'name_' . $employee->employee_id}}" aria-describedby="name" value="{{$employee->name}}" placeholder="name">
                            <span class="text-danger employee-error-text" id="{{'error-name_' . $employee->employee_id}}"></span>
                        </div>
                    </td>
                    <td>
                        <div class="{{'view_mode-' . $employee->employee_id}}">
                            {{ $employee->contact_number }}
                        </div>
                        <div class="{{'form-group edit_mode edit_mode-' . $employee->employee_id}}">
                            <input type="text" class="form-control" id="{{'contact_no_' . $employee->employee_id}}" aria-describedby="contact number" value="{{$employee->contact_number}}" placeholder="contact number">
                            <span class="text-danger employee-error-text" id="{{'error-contact_no_' . $employee->employee_id}}"></span>
                        </div>
                    </td>
                    <td>
                        <div class="{{'view_mode-' . $employee->employee_id}}">
                            @foreach ($employee->hobbies as $hobby)
                                {{ ucfirst($hobby->name) }}
                                @if(!$loop->last)
                                    ,
                                @endif
                            @endforeach
                        </div>
                        <div class="{{'form-group edit_mode edit_mode-' . $employee->employee_id}}">
                            @php
                                $employee_hobbies = json_decode($employee->hobbies, TRUE);
                                $employee_hobby_ids = array_column($employee_hobbies, 'hobby_id');
                            @endphp
                            @isset($hobbies)
                                @foreach ($hobbies as $hobby)
                                    <div class="form-check">
                                        <input class="form-check-input" name="{{'hobbies_' . $employee->employee_id}}" type="checkbox" 
                                            value="{{$hobby->hobby_id}}" id=" 'hobby' . {{$hobby->hobby_id}}"  
                                            {{ (in_array($hobby->hobby_id, $employee_hobby_ids)) ? 'checked' : '' }}>
                                        <label class="form-check-label" for="hobby">
                                            {{ $hobby->name }}
                                        </label>
                                    </div>
                                @endforeach
                            @endisset
                            <span class="text-danger employee-error-text" id="{{'error-employee_hobbies_' . $employee->employee_id}}"></span>
                        </div>
                    </td>
                    <td>
                        <div class="{{'view_mode-' . $employee->employee_id}}">
                            {{ ucfirst($employee->category->name) }}
                        </div>
                        <div class="{{'form-group edit_mode edit_mode-' . $employee->employee_id}}">
                            <select class="custom-select mr-sm-2" id="{{'category_' . $employee->employee_id}}">
                                @isset($categories)
                                    @foreach ($categories as $category)
                                        <option value="{{$category->category_id}}" {{ ( $employee->category_id == $category->category_id) ? 'selected' : '' }}>
                                            {{$category->name}}
                                        </option>
                                    @endforeach
                                @endisset
                            </select>
                            <span class="text-danger employee-error-text" id="{{'error-category_' . $employee->employee_id}}"></span>
                        </div>
                    </td>
                    <td>
                        <div>
                            <img src="{{ $employee->image }}" height="100px" width="100px"></img>
                        <div>
                        <div class="{{'form-group mt-3 edit_mode edit_mode-' . $employee->employee_id}}">
                            <input type="file" class="form-control-file" id="{{'profile_pic_' . $employee->employee_id}}">
                            <span class="text-danger employee-error-text" id="{{'error-profile_pic_' . $employee->employee_id}}"></span>
                        </div>                
                    </td>
                    <td>
                    <a href="#" id="" class="{{'view_mode-' . $employee->employee_id}}" onClick="edit({{$employee->employee_id}})">edit</a> 
                    <button class="{{'btn-primary edit_mode edit_mode-' . $employee->employee_id}}" id="update_employee_btn" onClick="update({{$employee->employee_id}})">update</button>
                    / 
                    <a href="#" id="delete_employee_link" onClick="deleteEmployee({{$employee->employee_id}})">delete</a></td>
                </tr>
                @endforeach
            @endisset
        </tbody>
    </table>
</div>