

@props(["modal"])

<div v-show = "{{ $modal }}" class = "overflow-y-auto fixed inset-0 z-10" aria-labelledby = "modal-title" role = "dialog" aria-modal = "true">

    <div class = "flex justify-center text-center min-h-screen items-end pt-4 px-4 pb-20 sm:block sm:p-0">

        <div v-on:click = "{{ $modal }} = false" class = "fixed bg-gray-500 bg-opacity-75 transition-opacity inset-0" aria-hidden = "true"></div>

        <span class = "hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden = "true">&#8203;</span>

        <div class = "bg-white inline-block align-bottom rounded-lg text-left overflow-hidden shadow-xl transform transition-all w-full sm:my-8 sm:align-middle sm:max-w-lg sm:w-full">

            <div class = "bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">

                <div class = "sm:flex sm:items-start">

                    <div class = "text-center w-full sm:text-left">

                        <h3 class = "text-lg font-medium leading-6 text-gray-900" id = "modal-title">{{$title}}</h3>

                        <div class = "mt-2">{{$content}}</div>

                    </div>

                </div>

            </div>

            <div class = "bg-gray-50 px-4 py-3 sm:flex sm:flex-row-reverse sm:px-6">{{$footer}}</div>

        </div>

    </div>

</div>

