<div class="modal modal-blur fade" id="modal-approve" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-sm modal-dialog-centered" role="document">
        <div class="modal-content">
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            <div class="modal-status bg-success"></div>
            <div class="modal-body text-center py-4">
                <!-- Download SVG icon from http://tabler-icons.io/i/circle-check -->
                <svg xmlns="http://www.w3.org/2000/svg" class="icon mb-2 text-green icon-lg" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"></path><path d="M12 12m-9 0a9 9 0 1 0 18 0a9 9 0 1 0 -18 0"></path><path d="M9 12l2 2l4 -4"></path></svg>
                <h3>Qabul qilish</h3>
                <div class="text-muted">Qabul qilingan ijro qayta o'zgartirish kiritish va bekor qilish uchun mavjud bo'lmaydi,
                    qabul qilingan statusi biriktiladi va ijrochiga imtiyoz ballari o'tkaziladi.</div>
            </div>
            <div class="modal-footer">
                <div class="w-100">
                    <div class="row">
                        <div class="col"><a href="#" class="btn w-100" data-bs-dismiss="modal">
                                Ortga
                            </a></div>
                        <form action="{{route('head.process.approve', $process->id)}}" method="POST" class="col">
                            @csrf
                            <button class="btn btn-success w-100">
                                Qabul qilish
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
