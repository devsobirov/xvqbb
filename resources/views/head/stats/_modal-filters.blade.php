<div class="modal modal-blur fade" id="modal-report" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <form action="{{route('head.stats.index')}}" class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Statistik ma'lumotlarni filterlash @if($filters) ({{$filters}}) @endif</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-lg-6">
                        <div class="mb-3">
                            <label class="form-label">Sanadan</label>
                            <input type="date" name="from" min="{{$min}}" value="{{request('from')}}" class="form-control">
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="mb-3">
                            <label class="form-label">Sanagacha</label>
                            <input type="date" name="to" max="{{$max}}" value="{{request('to')}}" class="form-control">
                        </div>
                    </div>
                    <div class="col-lg-12">
                        <div class="mb-3">
                            <label class="form-label">Bo'limlar bo'yicha saralash</label>
                            <select class="form-select" name="department_id">
                                <option value="">Barcha bo'limlar</option>
                                @foreach($departments as $department)
                                    <option value="{{$department->id}}" @if($department->id == request('department_id')) selected @endif >{{$department->name}}</option>
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
