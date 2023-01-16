<div class="box-body">
    <div class="form-group">
        <label for="title">Title</label>
        <input type="text" name="title" class="form-control" id="title" placeholder="Enter Title"
            value="{{ old('title', $editProduct->title ?? '') }}">
        @error('title')
            <span class="text-danger">{{ $message }}</span>
        @enderror
    </div>
    <div class="form-group">
        <label for="short description">Short Description</label>
        <input type="text" name="short_description" class="form-control" id="short_description"
            placeholder="Enter Short Description"
            value="{{ old('short_description', $editProduct->short_description ?? '') }}">
        @error('short_description')
            <span class="text-danger">{{ $message }}</span>
        @enderror
    </div>
    <div class="form-group">
        <label for="long description">Long Description</label>
        <textarea name="long_description" class="form-control" id="long_description" placeholder="Enter Long Description"
            rows="4" cols="6">
            {{ old('long_description', $editProduct->long_description ?? '') }}</textarea>
        @error('long_description')
            <span class="text-danger">{{ $message }}</span>
        @enderror
    </div>
    <div class="form-group">
        <label for="Category">Category</label>
        <select name="category_id" id="category_id">
            <option value="">Select Category</option>
            @foreach ($categories as $item)
                <option value="{{ $item->id ?? '-' }}" disabled>
                    {{ $item->title ?? '' }}
                </option>
                @if ($item->childCategories)
                    @foreach ($item->childCategories as $child)
                        <option value="{{ $child->id ?? '-' }}" disabled>
                            -{{ $child->title ?? '' }}
                        </option>
                        @if ($child->childCategories)
                            @foreach ($child->childCategories as $gchild)
                                <option value="{{ $gchild->id ?? '-' }}"
                                    @if (isset($editProduct) && $editProduct->category_id == $gchild->id) selected @endif>
                                    --{{ $gchild->title ?? '' }}
                                </option>
                            @endforeach
                        @endif
                    @endforeach
                @endif
            @endforeach
        </select>

        @error('category_id')
            <span class="text-danger">{{ $message }}</span>
        @enderror
    </div>
    <div class="form-group">
        <label for="Image">Feature image</label>
        <div class="holder">
            <img id="imgPreview" src="{{ asset(\Storage::url($editProduct->pImage ?? '')) }}" alt="pic"
                style="height: 100px; width:fit-content">
        </div>
        <input type="file" name="pImage" id="pImage">
        {{-- value="{{ old('pImage', $editProduct->pImage ?? '') }}" --}}
        @error('pImage')
            <span class="text-danger">{{ $message }}</span>
        @enderror
        <p class="help-block"><i>Size of image must be less than 1500KB <i></p>
    </div>
    <div class="form-group">
    </div>
    <div class="form-group">
        <label for="Price">Price</label>
        <input type="number" name="price" class="form-control" id="price" placeholder="Enter Price"
            value="{{ old('price', $editProduct->price ?? '') }}">
        @error('price')
            <span class="text-danger">{{ $message }}</span>
        @enderror
    </div>
    @if (isset($editProduct))
        <div class="form-group">
            <label for="status">Status</label>
            <div>
                <input type="radio" id="Active" name="status" value="Active"
                    @if ($editProduct->status == 'Active') checked @endif>
                {{-- checked --}}
                {{-- ???????????????????? --}}
                <label for="active">Active</label>
            </div>
            <div>
                <input type="radio" id="Inactive" name="status" value="Inactive"
                    @if ($editProduct->status == 'Inactive') checked @endif>

                <label for="inactive">Inactive</label>
            </div>
        </div>
    @endif

    {{-- <div class="container">
    <div class="form-group">
        <label for="title">Title</label>
        <input type="text" name="title" class="form-control" id="title" placeholder="Enter Title"
            value="{{ old('title', $editProduct->theSpecifications->title ?? '') }}">
        @error('title')
            <span class="text-danger">{{ $message }}</span>
        @enderror
    </div>
    <div class="form-group">
        <label for="description">Description</label>
        <input type="text" name="description" class="form-control" id="description" placeholder="Enter Description"
            value="{{ old('description', $editProduct->theSpecifications->description ?? '') }}">
        @error('description')
            <span class="text-danger">{{ $message }}</span>
        @enderror
    </div>
</div> --}}

    <h4><label>Add Specifications</label></h4>

    <div class="row">
        <div class="col-md-12">
            <table class="table table-bordered table-specifications">
                <thead>
                    <tr>
                        <th>SN</th>
                        <th>Title</th>
                        <th>Specification</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    {{-- @if (session()->getOldInput() != [] && isset(session()->getOldInput()['spec']))
                    @foreach (array_keys(session()->getOldInput()['spec'] ?? []) as $i)
                    <tr data-row="{{ $loop->iteration }}">
                        <td>{{ $loop->iteration }}</td>
                        <td><textarea name="spec[title][]" class="form-control"
                                required>{{ old('spec')['title'][$i] }}</textarea></td>
                        <td><textarea name="spec[specification][]" class="form-control"
                                required>{{ old('spec')['specification'][$i] }}</textarea>
                        </td>
                        <td><button type="button" class="btn btn-danger btn-sm btn-delete-specifications"
                                data-feature=""><i class="fa fa-minus-circle"></i></button></td>
                    </tr>
                    @endforeach    
                    @endif --}}

                    @if (isset($editProduct))
                        @foreach ($editProduct->theSpecifications as $key => $item)
                            <tr data-row="{{ $loop->iteration }}">
                                <td>{{ $loop->iteration }}</td>
                                <td>
                                    <textarea name="spec[title][{{ $item->id }}]" class="form-control" required>{{ old('spec[title][$item->id]', $item->title ?? '') }}</textarea>
                                </td>
                                <td>
                                    <textarea name="spec[specification][{{ $item->id }}]" class="form-control" required>{{ old('spec[specification][$item->id]', $item->description ?? '') }}</textarea>
                                </td>
                                <td><button type="button" class="btn btn-danger btn-sm btn-delete-specifications"
                                        data-feature="" data-id="{{ $item->id }}"><i
                                            class="fa fa-minus-circle"></i></button></td>
                            </tr>
                        @endforeach
                    @endif
                    @error('deleted_ids')
                        {{ $message }}
                    @enderror
                </tbody>
                <tfoot>
                    <tr>
                        <th></th>
                        <th></th>
                        <th></th>
                        <th>
                            <button class="btn btn-primary btn-sm btn-add-specifications">
                                Add New
                            </button>
                        </th>
                    </tr>
                </tfoot>
            </table>
        </div>
    </div>












    {{-- <div class="box">
        <label for="Specifications">Specifications</label>
        <!-- Repeater Content -->
        <div class="items" data-group="test">
            <div class="item-content">
                <div class="form-group">
                    <label for="inputTitle" class="col-lg-2 control-label">Title</label>
                    <div class="col-lg-10">
                        <input type="text" name="spec_title[]" class="form-control" id="inputTitle"
                            placeholder="Title" data-name="title"
                            value="{{ old('spec_title[0]', $editProduct->theSpecifications->title[0] ?? '') }}">
                        @error('title')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
                <div class="form-group">
                    <label for="inputDescription" class="col-lg-2 control-label">Description</label>
                    <div class="col-lg-10">
                        <input type="text" name="spec_description[]" class="form-control" id="inputDescription"
                            placeholder="Description" data-skip-name="true" data-name="description">
                    </div>
                </div>
            </div>
            <!-- Repeater Remove Btn -->
            <div class="pull-right repeater-remove-btn">
                <button id="remove-btn" class="btn btn-danger" onclick="$(this).parents('.items').remove()">
                    Remove
                </button>
            </div>
        </div>
        <div class="items" data-group="test">
            <div class="item-content">
                <div class="form-group">
                    <label for="inputTitle" class="col-lg-2 control-label">Title</label>
                    <div class="col-lg-10">
                        <input type="text" name="spec_title[{{ $editProduct->theSpecifications->id[1] }}]" class="form-control" id="inputTitle"
                            placeholder="Title" data-name="title"
                            value="{{ old('spec_title[1]', $editProduct->theSpecifications->title[1] ?? '') }}">
                        @error('title')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
                <div class="form-group">
                    <label for="inputDescription" class="col-lg-2 control-label">Description</label>
                    <div class="col-lg-10">
                        <input type="text" name="spec_description[]" class="form-control" id="inputDescription"
                            placeholder="Description" data-skip-name="true" data-name="description">
                    </div>
                </div>
            </div>
            <!-- Repeater Remove Btn -->
            <div class="pull-right repeater-remove-btn">
                <button id="remove-btn" class="btn btn-danger" onclick="$(this).parents('.items').remove()">
                    Remove
                </button>
            </div>
        </div>
    </div> --}}

</div> <!-- /.box-body -->
