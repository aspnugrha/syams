<div class="card card-profile">
    {{-- <div class="card-header" style="background-image: url('{{ asset('assets/backend') }}/img/blogpost.jpg')">
        <div class="profile-picture">
            <div class="avatar avatar-xl d-flex justify-content-center">
            </div>
        </div>
    </div> --}}
    <div class="card-body">
        <div class="user-profile text-center">
            <div class="w-100 d-flex justify-content-center mb-2">
                <img src="{{ ($data->image ? asset('assets/uploads/user/'.$data->image) : asset('assets/backend/images/user/avatar-2.jpg')) }}" alt="Profile {{ $data->name }}" class="avatar-img rounded-circle" style="width: 100px;height: 100px;object-fit: cover;">
            </div>
            <h4 class="name">{{ $data->name }}</h4>
            {{-- <div class="job">Crew</div> --}}
            <div class="desc">
                <span class="badge bg-{{ $data->active ? 'success' : 'danger' }}">{{ $data->active ? 'Active' : 'Not Active' }}</span>
            </div>
            <div class="social-media">
                <a class="btn btn-info btn-sm btn-link" href="#">
                    <span class="btn-label just-icon">
                        <i class="mdi mdi-email"></i>
                    </span>
                </a>
                <a class="btn btn-info btn-sm btn-link" href="#">
                    <span class="btn-label just-icon">
                        <i class="mdi mdi-phone"></i>
                    </span>
                </a>
            </div>
            {{-- <div class="view-profile">
            <a href="#" class="btn btn-secondary w-100">View Full Profile</a>
            </div> --}}
        </div>
    </div>
    <div class="card-footer">
        <div class="row user-stats text-center">
            <div class="col">
                <div class="number">{{ $data->email }}</div>
                <div class="title text-muted">Email</div>
            </div>
            <div class="col">
                <div class="number">{{ $data->phone_number }}</div>
                <div class="title text-muted">Phone Number</div>
            </div>
            <div class="col">
                <div class="number">{{ date('d F Y H:i', strtotime($data->created_at)) }}</div>
                <div class="title text-muted">Dibuat tanggal</div>
            </div>
        </div>
    </div>
</div>