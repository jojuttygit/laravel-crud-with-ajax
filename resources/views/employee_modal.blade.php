<div class="modal fade" id="add_employee" tabindex="-1" role="dialog" aria-labelledby="Employee Model" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="add_employee_title">Add Employee</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
            <form method="POST" enctype="multipart/form-data" id="add_employee_form">
                <div class="form-group">
                    <label for="name"><strong>Name</strong></label>
                    <input type="text" class="form-control" id="name" aria-describedby="name" placeholder="name">
                    <span class="text-danger employee-error-text" id="error-name"></span>
                </div>
                <div class="form-group">
                    <label for="contact_no"><strong>Contact no</strong></label>
                    <input type="text" class="form-control" id="contact_no" aria-describedby="contact number" placeholder="contact number">
                    <span class="text-danger employee-error-text" id="error-contact_no"></span>
                </div>
                <div class="form-group">
                    <label for="hobby"><strong>Hobby</strong></label>
                    @isset($hobbies)
                        @foreach ($hobbies as $hobby)
                            <div class="form-check">
                                <input class="form-check-input" name="hobbies" type="checkbox" value="{{$hobby->hobby_id}}" id=" 'hobby' . {{$hobby->hobby_id}}">
                                <label class="form-check-label" for="hobby">
                                    {{ $hobby->name }}
                                </label>
                            </div>
                        @endforeach
                    @endisset
                    <span class="text-danger employee-error-text" id="error-employee_hobbies"></span>
                </div>
                <div class="form-group">
                    <label for="category"><strong>Category</strong></label>
                    <select class="custom-select mr-sm-2" id="category">
                        <option selected>select</option>
                        @isset($categories)
                            @foreach ($categories as $category)
                                <option value="{{$category->category_id}}">{{$category->name}}</option>
                            @endforeach
                        @endisset
                    </select>
                    <span class="text-danger employee-error-text" id="error-category"></span>
                </div>
                <div class="form-group">
                    <label for="profile_pic"><strong>Profile Pic</strong></label>
                    <input type="file" class="form-control-file" id="profile_pic">
                    <span class="text-danger employee-error-text" id="error-profile_pic"></span>
                </div>
            </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary" id="create_employee_btn">Add</button>
            </div>
        </div>
    </div>
</div>