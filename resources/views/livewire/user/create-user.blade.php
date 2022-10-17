<h2 class="section-title">Create New </h2>
<p class="section-lead mb-3">
  On this page you can create a new post and fill in all fields.
</p>

<div class="row">
  <div class="col-12">
    <div class="card">
      <div class="card-header">
        <h4>Write Your Post</h4>
      </div>
      <div class="card-body">

      <form wire:submit.prevent="store">
        <div class="form-group row mb-4">
          <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Name</label>
          <div class="col-sm-12 col-md-7">
            <input type="text" class="form-control" wire:model="user.name">
            @error('name') <span class="text-red-500">{{ $message }}</span>@enderror
          </div>
        </div>

        <div class="form-group row mb-4">
          <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Email</label>
          <div class="col-sm-12 col-md-7">
            <input type="text" class="form-control" wire:model="user.email">
            @error('email') <span class="text-red-500">{{ $message }}</span>@enderror
          </div>
        </div>

        <div class="form-group row mb-4">
          <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Password</label>
          <div class="col-sm-12 col-md-7">
            <input type="password" class="form-control" wire:model="user.password">
            @error('password') <span class="text-red-500">{{ $message }}</span>@enderror
          </div>
        </div>

        <!-- <div class="form-group row mb-4">
          <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Confirm Password</label>
          <div class="col-sm-12 col-md-7">
            <input type="password" class="form-control" wire:model.defer="user.password_confirmation">
            @error('password') <span class="text-red-500">{{ $message }}</span>@enderror
          </div>
        </div> -->

        <div class="form-group row mb-4">
          <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Team</label>
          <div class="col-sm-12 col-md-7">
            <select class="form-control select2">
              <option selected> Select Team </option>
              @foreach ($data as $team)
                <option value="{{ $team->id }}" wire:model="user.team">{{ $team->name }}</option>
              @endforeach
            </select>
            </select>
          </div>
        </div>

        <div class="form-group row mb-4">
          <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3"></label>
          <div class="col-sm-12 col-md-7">
            <button type="submit" class="btn btn-primary">Create User</button>
          </div>
        </div>

      </form>

      </div>
    </div>
  </div>
</div>