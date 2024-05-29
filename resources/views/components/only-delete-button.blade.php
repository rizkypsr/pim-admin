<nobr>
    <form action="{{ $deleteRoute }}" method="POST" style="display: inline;">
        @csrf
        @method('DELETE')
        <button type="submit" class="btn btn-xs btn-default text-danger mx-1 shadow" title="Hapus"
            onclick="return confirm('Anda yakin ingin menghapus?');">
            <i class="fa fa-lg fa-fw fa-trash"></i>
        </button>
    </form>
</nobr>
