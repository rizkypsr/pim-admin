<nobr>
    <a href="{{ $editRoute }}" class="btn btn-xs btn-default text-primary mx-1 shadow" title="Ubah"><i
            class="fa fa-lg fa-fw fa-pen"></i></a>
    <form action="{{ $deleteRoute }}" method="POST" style="display: inline;">
        @csrf
        @method('DELETE')
        <button type="submit" class="btn btn-xs btn-default text-danger mx-1 shadow" title="Hapus"
            onclick="return confirm('Anda yakin ingin menghapus?');">
            <i class="fa fa-lg fa-fw fa-trash"></i>
        </button>
    </form>
    @if (isset($showRoute))
        <a href="{{ $showRoute }}" class="btn btn-xs btn-default text-info mx-1 shadow" title="Lihat">
            <i class="fa fa-lg fa-fw fa-eye"></i>
        </a>
    @endif
</nobr>
