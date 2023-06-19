<?php
	defined('security') or die('Access denied'); // Add light protection against file access

	// To insert an svg icon:
	// <svg class="icon icon-search"><use xlink:href="#icon-search"></use></svg>
?>

<div hidden="hidden" class="null-svg-elements">
	<svg xmlns="http://www.w3.org/2000/svg">
		<symbol id="icon-search" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
			<circle cx="11" cy="11" r="8"></circle><line x1="21" y1="21" x2="16.65" y2="16.65"></line>
		</symbol>
		<symbol id="icon-star" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
			<polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"></polygon>
		</symbol>
		<symbol id="icon-star-fill" viewBox="0 0 24 24" fill="currentColor" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
			<polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"></polygon>
		</symbol>
		<symbol id="icon-git-pull-request" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
			<circle cx="18" cy="18" r="3"></circle><circle cx="6" cy="6" r="3"></circle><path d="M13 6h3a2 2 0 0 1 2 2v7"></path><line x1="6" y1="9" x2="6" y2="21"></line>
		</symbol>
		<symbol id="icon-home" viewBox="0 0 24 24" fill="currentColor">
			<path d="M9.135 20.773v-3.057c0-.78.637-1.414 1.423-1.414h2.875c.377 0 .74.15 1.006.414.267.265.417.625.417 1v3.057c-.002.325.126.637.356.867.23.23.544.36.87.36h1.962a3.46 3.46 0 002.443-1 3.41 3.41 0 001.013-2.422V9.867c0-.735-.328-1.431-.895-1.902l-6.671-5.29a3.097 3.097 0 00-3.949.072L3.467 7.965A2.474 2.474 0 002.5 9.867v8.702C2.5 20.464 4.047 22 5.956 22h1.916c.68 0 1.231-.544 1.236-1.218l.027-.009z"></path>
		</symbol>
		<symbol id="icon-more-vertical" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linejoin="round">
			<circle cx="12" cy="12" r="1"></circle><circle cx="12" cy="5" r="1"></circle><circle cx="12" cy="19" r="1"></circle>
		</symbol>
		<symbol id="icon-more-horizontal" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linejoin="round">
			<circle cx="12" cy="12" r="1"></circle><circle cx="19" cy="12" r="1"></circle><circle cx="5" cy="12" r="1"></circle>
		</symbol>
		<symbol id="icon-article" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
			<path d="M12 20h9"></path><path d="M16.5 3.5a2.121 2.121 0 0 1 3 3L7 19l-4 1 1-4L16.5 3.5z"></path>
		</symbol>
		<symbol id="icon-options" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
			<circle cx="12" cy="12" r="3"></circle><path d="M19.4 15a1.65 1.65 0 0 0 .33 1.82l.06.06a2 2 0 0 1 0 2.83 2 2 0 0 1-2.83 0l-.06-.06a1.65 1.65 0 0 0-1.82-.33 1.65 1.65 0 0 0-1 1.51V21a2 2 0 0 1-2 2 2 2 0 0 1-2-2v-.09A1.65 1.65 0 0 0 9 19.4a1.65 1.65 0 0 0-1.82.33l-.06.06a2 2 0 0 1-2.83 0 2 2 0 0 1 0-2.83l.06-.06a1.65 1.65 0 0 0 .33-1.82 1.65 1.65 0 0 0-1.51-1H3a2 2 0 0 1-2-2 2 2 0 0 1 2-2h.09A1.65 1.65 0 0 0 4.6 9a1.65 1.65 0 0 0-.33-1.82l-.06-.06a2 2 0 0 1 0-2.83 2 2 0 0 1 2.83 0l.06.06a1.65 1.65 0 0 0 1.82.33H9a1.65 1.65 0 0 0 1-1.51V3a2 2 0 0 1 2-2 2 2 0 0 1 2 2v.09a1.65 1.65 0 0 0 1 1.51 1.65 1.65 0 0 0 1.82-.33l.06-.06a2 2 0 0 1 2.83 0 2 2 0 0 1 0 2.83l-.06.06a1.65 1.65 0 0 0-.33 1.82V9a1.65 1.65 0 0 0 1.51 1H21a2 2 0 0 1 2 2 2 2 0 0 1-2 2h-.09a1.65 1.65 0 0 0-1.51 1z"></path>
		</symbol>
		<symbol id="icon-folder" viewBox="0 0 72 72">
			<path d="M60.72,30.09H34.93a3.66,3.66,0,0,1-3.66-3.67V16a3.66,3.66,0,0,1,3.66-3.66H60.72A3.66,3.66,0,0,1,64.38,16V26.42A3.66,3.66,0,0,1,60.72,30.09Z" fill="#6c87fe"/><path d="M64.14,65.56H7.86A7.63,7.63,0,0,1,.53,57.75V14.24a7.63,7.63,0,0,1,7.33-7.8H29.73a5.47,5.47,0,0,1,4.85,3.07l3.78,12.3H64.14a7,7,0,0,1,7.33,7.09V57.75A7.63,7.63,0,0,1,64.14,65.56Z" fill="#8aa3ff"/><path d="M2.54,63.19C5.14,66,8.09,65.56,10,65.56H63.2a7.82,7.82,0,0,0,6.26-2.37Z" fill="#798bff"/>
		</symbol>
		<symbol id="icon-dir-color" viewBox="0 0 24 24" stroke-linecap="round" stroke-linejoin="round">
			<path d="M22 19a2 2 0 0 1-2 2H4a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h5l2 3h9a2 2 0 0 1 2 2z"></path>
		</symbol>
		<symbol id="icon-file-color" viewBox="0 0 24 24" stroke-linecap="round" stroke-linejoin="round">
			<path d="M13 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V9z"></path><polyline points="13 2 13 9 20 9"></polyline>
		</symbol>
		<symbol id="icon-refresh" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.4" stroke-linecap="round" stroke-linejoin="round">
			<polyline points="23 4 23 10 17 10"></polyline><polyline points="1 20 1 14 7 14"></polyline><path d="M3.51 9a9 9 0 0 1 14.85-3.36L23 10M1 14l4.64 4.36A9 9 0 0 0 20.49 15"></path>
		</symbol>
		<symbol id="icon-arrow-right-line" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3" stroke-linecap="round" stroke-linejoin="round">
			<line x1="5" y1="12" x2="19" y2="12"></line><polyline points="12 5 19 12 12 19"></polyline>
		</symbol>
		<symbol id="icon-arrow-right" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.4" stroke-linecap="round" stroke-linejoin="round">
			<polyline points="9 18 15 12 9 6"></polyline>
		</symbol>
		<symbol id="icon-arrow-left" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.4" stroke-linecap="round" stroke-linejoin="round">
			<polyline points="15 18 9 12 15 6"></polyline>
		</symbol>
		<symbol id="icon-upload" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.4" stroke-linecap="round" stroke-linejoin="round">
			<path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"></path><polyline points="17 8 12 3 7 8"></polyline><line x1="12" y1="3" x2="12" y2="15"></line>
		</symbol>
		<symbol id="icon-link" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.4" stroke-linecap="round" stroke-linejoin="round">
			<path d="M15 7h3a5 5 0 0 1 5 5 5 5 0 0 1-5 5h-3m-6 0H6a5 5 0 0 1-5-5 5 5 0 0 1 5-5h3"></path><line x1="8" y1="12" x2="16" y2="12"></line>
		</symbol>
		<symbol id="icon-link2" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
			<path d="M10 13a5 5 0 0 0 7.54.54l3-3a5 5 0 0 0-7.07-7.07l-1.72 1.71"></path><path d="M14 11a5 5 0 0 0-7.54-.54l-3 3a5 5 0 0 0 7.07 7.07l1.71-1.71"></path>
		</symbol>
		<symbol id="icon-corner-left-down" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
			<polyline points="14 15 9 20 4 15"></polyline><path d="M20 4h-7a4 4 0 0 0-4 4v12"></path>
		</symbol>
		<symbol id="icon-info" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.4" stroke-linecap="round" stroke-linejoin="round">
			<circle cx="12" cy="12" r="10"></circle><line x1="12" y1="16" x2="12" y2="12"></line><line x1="12" y1="8" x2="12.01" y2="8"></line>
		</symbol>
		<symbol id="icon-edit" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.4" stroke-linecap="round" stroke-linejoin="round">
			<path d="M17 3a2.828 2.828 0 1 1 4 4L7.5 20.5 2 22l1.5-5.5L17 3z"></path>
		</symbol>
		<symbol id="icon-edit-line" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
			<path d="M18.6677 11.4071L11.0742 19.0006C9.5555 20.5193 3.98692 23.0503 2.46833 21.5317C0.949737 20.0131 3.48063 14.4445 4.99933 12.9258C4.99933 12.9258 9.55534 8.36959 12.5928 5.3323C12.6249 5.30029 12.6571 5.268 12.6896 5.23548C12.9268 4.99808 13.1767 4.74803 13.4379 4.49648C13.4481 4.508 13.4587 4.51929 13.4697 4.53032L19.4697 10.5303C19.4808 10.5413 19.492 10.5519 19.5035 10.5621C19.2519 10.8234 19.0017 11.0734 18.7642 11.3107C18.7318 11.3431 18.6996 11.3752 18.6677 11.4071ZM20.5047 9.44397L14.5561 3.49534C16.3425 2.04273 18.4918 1.10655 20.6927 3.30735C22.8935 5.50816 21.9573 7.65755 20.5047 9.44397Z"/><path d="M13.2501 22C13.2501 21.5858 13.5858 21.25 14.0001 21.25H20.0001C20.4143 21.25 20.7501 21.5858 20.7501 22C20.7501 22.4142 20.4143 22.75 20.0001 22.75H14.0001C13.5858 22.75 13.2501 22.4142 13.2501 22Z"/>
		</symbol>
		<symbol id="icon-maximize" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
			<polyline points="15 3 21 3 21 9"></polyline><polyline points="9 21 3 21 3 15"></polyline><line x1="21" y1="3" x2="14" y2="10"></line><line x1="3" y1="21" x2="10" y2="14"></line>
		</symbol>
		<symbol id="icon-close" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
			<line x1="18" y1="6" x2="6" y2="18"></line><line x1="6" y1="6" x2="18" y2="18"></line>
		</symbol>
		<symbol id="icon-plus" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
			<line x1="12" y1="5" x2="12" y2="19"></line><line x1="5" y1="12" x2="19" y2="12"></line>
		</symbol>
		<symbol id="icon-plus-circle" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
			<circle cx="12" cy="12" r="10"></circle><line x1="12" y1="8" x2="12" y2="16"></line><line x1="8" y1="12" x2="16" y2="12"></line>
		</symbol>
		<symbol id="icon-external-link" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
			<path d="M18 13v6a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V8a2 2 0 0 1 2-2h6"></path><polyline points="15 3 21 3 21 9"></polyline><line x1="10" y1="14" x2="21" y2="3"></line>
		</symbol>
		<symbol id="icon-additem" viewBox="0 0 24 24" fill="currentColor">
			<path opacity="0.92" d="M8 16.75H5.43C2.74 16.75 1.25 15.27 1.25 12.57V5.43C1.25 2.74 2.73 1.25 5.43 1.25H10C12.69 1.25 14.18 2.73 14.18 5.43C14.18 5.84 13.84 6.18 13.43 6.18C13.02 6.18 12.68 5.84 12.68 5.43C12.68 3.55 11.88 2.75 10 2.75H5.43C3.55 2.75 2.75 3.55 2.75 5.43V12.57C2.75 14.45 3.55 15.25 5.43 15.25H8C8.41 15.25 8.75 15.59 8.75 16C8.75 16.41 8.41 16.75 8 16.75Z"/>
			<path opacity="0.92" d="M18.5703 22.75H14.0003C11.3103 22.75 9.82031 21.27 9.82031 18.57V11.43C9.82031 8.74 11.3003 7.25 14.0003 7.25H18.5703C21.2603 7.25 22.7503 8.73 22.7503 11.43V18.57C22.7503 21.27 21.2703 22.75 18.5703 22.75ZM14.0003 8.75C12.1203 8.75 11.3203 9.55 11.3203 11.43V18.57C11.3203 20.45 12.1203 21.25 14.0003 21.25H18.5703C20.4503 21.25 21.2503 20.45 21.2503 18.57V11.43C21.2503 9.55 20.4503 8.75 18.5703 8.75H14.0003Z"/>
			<path fill="#0d6efd" d="M18.1309 15.75H14.8809C14.4709 15.75 14.1309 15.41 14.1309 15C14.1309 14.59 14.4709 14.25 14.8809 14.25H18.1309C18.5409 14.25 18.8809 14.59 18.8809 15C18.8809 15.41 18.5409 15.75 18.1309 15.75Z"/>
			<path fill="#0d6efd" d="M16.5 17.3799C16.09 17.3799 15.75 17.0399 15.75 16.6299V13.3799C15.75 12.9699 16.09 12.6299 16.5 12.6299C16.91 12.6299 17.25 12.9699 17.25 13.3799V16.6299C17.25 17.0399 16.91 17.3799 16.5 17.3799Z"/>
		</symbol>


	</svg>
</div>