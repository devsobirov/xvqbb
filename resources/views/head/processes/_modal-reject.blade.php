<div class="modal modal-blur fade" id="modal-reject" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-sm modal-dialog-centered" role="document">
        <form action="{{route('head.process.reject', $process->id)}}" method="POST" class="modal-content">
            @csrf
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            <div class="modal-status bg-danger"></div>
            <div class="modal-body text-center py-4">
                <!-- Download SVG icon from http://tabler-icons.io/i/alert-triangle -->
                <svg xmlns="http://www.w3.org/2000/svg" class="icon mb-2 text-danger icon-lg" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"></path><path d="M10.24 3.957l-8.422 14.06a1.989 1.989 0 0 0 1.7 2.983h16.845a1.989 1.989 0 0 0 1.7 -2.983l-8.423 -14.06a1.989 1.989 0 0 0 -3.4 0z"></path><path d="M12 9v4"></path><path d="M12 17h.01"></path></svg>
                <h3>Bekor qilish xoxlaysizmi?</h3>
                <div class="text-muted mb-1">Ijro "Jarayonda" statusiga o'tkaziladi va to'ldirish uchun ijrochiga qaytariladi. Iltimos, bekor qilish sababini va tavsiyalarni ko'rsating</div>

                <div>
                    <textarea class="form-control @error('reject_msg') is-invalid @enderror" data-bs-toggle="autosize" rows="3" required name="reject_msg" placeholder="{{$process->reject_msg}}"></textarea>
                </div>
            </div>
            <div class="modal-footer">
                <div class="w-100">
                    <div class="row">
                        <div class="col"><a href="#" class="btn w-100" data-bs-dismiss="modal">
                                Ortga
                            </a>
                        </div>
                        <div class="col">
                            <button class="btn btn-danger w-100">
                                Bekor qilish
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>
