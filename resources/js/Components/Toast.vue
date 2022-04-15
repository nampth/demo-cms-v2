<script>
import Popup from "@/Plugins/popup";
export default {
  name: "PopupNotification",
  data() {
    return {
        type: '',
        text: ''
    };
  },
  methods: {
    hide() {
      // this method is unchanged
      $("#common_modal_notice").modal("hide");
    },
    confirm() {
      // we must check if this.onConfirm is function
      if (typeof this.onConfirm === "function") {
        // run passed function and then close the modal
        this.onConfirm();
        this.hide();
      } else {
        // we only close the modal
        this.hide();
      }
    },
    cancel() {
      // we must check if this.onConfirm is function
      console.log(typeof this.onCancel);
      if (typeof this.onCancel === "function") {
        console.log("cancellllll");
        // run passed function and then close the modal
        this.onCancel();
        this.hide();
      } else {
        // we only close the modal
        this.hide();
      }
    },

    show(params) {
      // // making modal visible
      // this.visible = true;
      // setting title and text
      this.type= params.type;
      this.text = params.text;
      // setting callback function

      this.onConfirm = params.onConfirm;
      this.onCancel = params.onCancel;
      $("#common_modal_notice").modal("show");
    },
  },
  computed: {
    btnOKText: function () {
      return this.okText || "Đồng ý";
    },
  },
  beforeMount() {

  },
};
</script>

<template>
  <div class="grid grid-cols-1 gap-2 justify-center items-center custom-toast">
    <!-- Danger -->
    <div v-if="type=='danger'"
      class="
        flex
        items-center
        text-white
        max-w-sm
        w-full
        bg-red-400
        shadow-md
        rounded-lg
        overflow-hidden
        mx-auto
      "
    >
      <div class="w-10 border-r px-2">
        <svg
          class="w-6 h-6"
          fill="none"
          stroke="currentColor"
          viewBox="0 0 24 24"
          xmlns="http://www.w3.org/2000/svg"
        >
          <path
            stroke-linecap="round"
            stroke-linejoin="round"
            stroke-width="2"
            d="M18.364 18.364A9 9 0 005.636 5.636m12.728 12.728A9 9 0 015.636 5.636m12.728 12.728L5.636 5.636"
          ></path>
        </svg>
      </div>

      <div class="flex items-center px-2 py-3">
        <div class="mx-3">
          <p>Your message</p>
        </div>
      </div>
    </div>

    <!-- succes -->
    <div v-if="type=='success'"
      class="
        flex
        items-center
        text-white
        max-w-sm
        w-full
        bg-green-400
        shadow-md
        rounded-lg
        overflow-hidden
        mx-auto
      "
    >
      <div class="w-10 border-r px-2">
        <svg
          class="w-6 h-6"
          fill="none"
          stroke="currentColor"
          viewBox="0 0 24 24"
          xmlns="http://www.w3.org/2000/svg"
        >
          <path
            stroke-linecap="round"
            stroke-linejoin="round"
            stroke-width="2"
            d="M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138z"
          ></path>
        </svg>
      </div>

      <div class="flex items-center px-2 py-3">
        <div class="mx-3">
          <p>Your message</p>
        </div>
      </div>
    </div>

    <!-- warning -->
    <div v-if="type=='warning'"
      class="
        flex
        items-center
        text-white
        max-w-sm
        w-full
        bg-yellow-400
        shadow-md
        rounded-lg
        overflow-hidden
        mx-auto
      "
    >
      <div class="w-10 border-r px-2">
        <svg
          class="w-6 h-6"
          fill="none"
          stroke="currentColor"
          viewBox="0 0 24 24"
          xmlns="http://www.w3.org/2000/svg"
        >
          <path
            stroke-linecap="round"
            stroke-linejoin="round"
            stroke-width="2"
            d="M20.618 5.984A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016zM12 9v2m0 4h.01"
          ></path>
        </svg>
      </div>

      <div class="flex items-center px-2 py-3">
        <div class="mx-3">
          <p>Your message</p>
        </div>
      </div>
    </div>
    <!-- info -->
    <div v-if="type=='info'"
      class="
        flex
        items-center
        text-white
        max-w-sm
        w-full
        bg-blue-400
        shadow-md
        rounded-lg
        overflow-hidden
        mx-auto
      "
    >
      <div class="w-10 border-r px-2">
        <svg
          class="w-6 h-6"
          fill="none"
          stroke="currentColor"
          viewBox="0 0 24 24"
          xmlns="http://www.w3.org/2000/svg"
        >
          <path
            stroke-linecap="round"
            stroke-linejoin="round"
            stroke-width="2"
            d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"
          ></path>
        </svg>
      </div>

      <div class="flex items-center px-2 py-3">
        <div class="mx-3">
          <p>Your message</p>
        </div>
      </div>
    </div>
  </div>
</template>

