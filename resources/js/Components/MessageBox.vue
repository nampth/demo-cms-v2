<script setup>
</script>
<script>
export default {
  props: {
    modalId: {
      type: String,
      default: "custom-msg-box",
    },
    title: {
      type: String,
      default: "",
    },
    content:{
      type:String,
      default: ""
    },
    textConfirm: {
      type: String,
      default: "Confirm",
    },
    textCancel: {
      type: String,
      default: "Cancel",
    },
  },
  methods: {
    handleClose() {
      this.$emit("close");
      document.getElementById(this.modalId).close();
    },
    handleConfirm() {
      this.$emit("confirm");
    },
  },
};
</script>

<template>
  <dialog :id="modalId" class="h-100 w-100 md:w-1/2 bg-white">
    <div
      class="
        flex flex-row
        justify-between
        p-6
        bg-white
        border-b border-gray-200
        rounded-tl-lg rounded-tr-lg
      "
    >
      <p class="font-semibold text-gray-800">{{ title }}</p>
      <svg
        @click="handleClose"
        class="w-6 h-6 cursor-pointer"
        fill="none"
        stroke="currentColor"
        viewBox="0 0 24 24"
        xmlns="http://www.w3.org/2000/svg"
      >
        <path
          stroke-linecap="round"
          stroke-linejoin="round"
          stroke-width="2"
          d="M6 18L18 6M6 6l12 12"
        ></path>
      </svg>
    </div>
    <div class="flex flex-col px-6 py-5 bg-gray-100">
      <p v-html="content"></p>
    </div>
    <div
      class="
        flex flex-row
        items-center
        justify-between
        p-5
        bg-white
        border-t border-gray-200
        rounded-bl-lg rounded-br-lg
      "
    >
      <p
        class="font-semibold text-gray-600 cursor-pointer"
        @click="handleClose"
      >
        {{ textCancel }}
      </p>
      <button
        class="
          px-4
          py-2
          text-white
          font-semibold
          bg-blue-500
          rounded
          flex
          disabled:opacity-70
        "
        @click="handleConfirm"
      >
        {{ textConfirm }}
      </button>
    </div>
  </dialog>
</template>
<style>
dialog {
  padding: 0;
}
dialog[open] {
  animation: appear 0.15s cubic-bezier(0, 1.8, 1, 1.8);
}

dialog::backdrop {
  background: linear-gradient(45deg, rgba(0, 0, 0, 0.5), rgba(54, 54, 54, 0.5));
  backdrop-filter: blur(3px);
}

@keyframes appear {
  from {
    opacity: 0;
    transform: translateX(-3rem);
  }

  to {
    opacity: 1;
    transform: translateX(0);
  }
}
</style>
