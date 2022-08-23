<button class="btn btn-danger btn-delete-category" data-fancybox href="#confirm_block">Delete</button>

<div id="confirm_block" class="block-confirm">
    {{ $message }}
    <br>
    <br>
    <form action="{{ $href }}" method="POST">

        @csrf
        @method('DELETE')

        <button class="btn btn-danger btn-push-confirm">Yes</button>
        <button class="btn btn-danger btn-close-fancybox">No</button>
    </form>
</div>
