<div class="modal modal-blur fade" id="modal-report" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <form action="{{route('head.tasks.index')}}" class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Topshiriqlarni ma'lumotlarni filterlash @if($filters) ({{$filters}}) @endif</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="mb-3">
                            <label class="form-label">Nomi, kod yoki ID bo'yicha izlash</label>
                            <input type="text" name="search" value="{{request('search')}}" class="form-control">
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="mb-3">
                            <label class="form-label">Boshlanishi - Sanadan</label>
                            <input type="date" name="starts_from" value="{{request('starts_from')}}" class="form-control">
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="mb-3">
                            <label class="form-label">Boshlanishi -  - Sanagacha</label>
                            <input type="date" name="starts_to" value="{{request('starts_to')}}" class="form-control">
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="mb-3">
                            <label class="form-label">Tugashi - Sanadan</label>
                            <input type="date" name="expires_from" value="{{request('expires_from')}}" class="form-control">
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="mb-3">
                            <label class="form-label">Tugashi -  - Sanagacha</label>
                            <input type="date" name="expires_to" value="{{request('expires_to')}}" class="form-control">
                        </div>
                    </div>
                    <div class="col-lg-12">
                        <div class="mb-3">
                            <label class="form-label">Bo'limlar bo'yicha saralash</label>
                            <select class="form-select" name="department_id">
                                <option value="">Barcha bo'limlar</option>
                                @foreach(\App\Models\Department::getForList() as $department)
                                    <option value="{{$department->id}}" @if($department->id == request('department_id')) selected @endif >{{$department->name}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-lg-12">
                        <div class="mb-3">
                            <label class="form-label">Topshiriq statusi boyicha saralash</label>
                            <select class="form-select" name="status">
                                <option value="">Barcha statuslar</option>
                                @foreach(\App\Helpers\TaskStatusHelper::STATUSES as $id => $name)
                                    <option value="{{$id}}" @if($id === request('status')) selected @endif >{{$name}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <a href="#" class="btn btn-outline-primary" data-bs-dismiss="modal">
                    Bekor qilish
                </a>
                <button class="btn btn-primary ms-auto">
                    <!-- Download SVG icon from http://tabler-icons.io/i/plus -->
                    <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"></path><path d="M12 5l0 14"></path><path d="M5 12l14 0"></path></svg>
                    Saralash
                </button>
            </div>
        </form>
    </div>
</div>
