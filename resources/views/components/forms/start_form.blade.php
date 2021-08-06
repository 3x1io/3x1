<div id="vue_form">
<main-form
        :action="'{{ $action }}'"
        :data="{{ $data }}"
        :set_from="{{ $form }}"
        :redirect="'{{ $redirect }}'"
        :items="{{ $items }}"
        v-cloak
        inline-template>
    <form class="needs-validation" method="{{ $method }}" @submit.prevent="onSubmit" :action="action">