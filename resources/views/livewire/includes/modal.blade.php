<div class="modal micromodal-slide w-10" id="modal-message" aria-hidden="true">
    <div class="modal__overlay" tabindex="-1" data-micromodal-close>
        <div class="modal__container w-10" role="dialog" aria-modal="true" aria-labelledby="modal-1-title">
            <header class="modal__header">
                <h2 class="modal__title" id="modal-1-title">
                    Information
                </h2>
                <button class="modal__close" aria-label="Close modal" data-micromodal-close></button>
            </header>
            <main class="modal__content" id="modal-1-content">
                <p>
                    @if (session()->has('message'))
                        <div class="alert alert-success">
                            {!!session('message') !!}
                        </div>
                    @endif
                </p>
            </main>
            <footer class="modal__footer">

            </footer>
        </div>
    </div>
</div>
