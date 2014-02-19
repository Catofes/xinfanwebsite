set tabstop=4
set softtabstop=4
set shiftwidth=4
set autoindent
set cindent
set cinoptions={0,1s,t0,n-2,p2s,(03s,=.5s,>1s,=1s,:1s
set nu
filetype on
syntax on
if &term=="xterm"
	set t_Co=8
		set t_Sb=^[[4%dm
	set t_Sf=^[[3%dm
endif
set nocp
filetype plugin on
set completeopt=longest,menu
filetype indent on

let Tlist_Use_Right_Window=1
let Tlist_File_Fold_Auto_Close=1

set fileencoding=utf-8
set fileencodings=utf-8,gb2312,gb18030,gbk,ucs-bom,cp936,latin1
map <C-F12> :!ctags -R --c++-kinds=+p --fields=+iaS --extra=+q .<CR>

let g:clang_complete_copen=1
let g:clang_periodic_quickfix=1
let g:clang_snippets=1
let g:clang_close_preview=1
let g:neocomplcache_enable_at_startup = 1
let g:clang_use_library = 1
let g:clang_user_options='-I/home/herbertqiao/root/include'
