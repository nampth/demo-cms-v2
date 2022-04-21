<script setup>
import { onMounted, ref } from "vue";
import BreezeAuthenticatedLayout from "@/Layouts/Authenticated.vue";
import Modal from "@/Components/Modal.vue";
import MessageBox from "@/Components/MessageBox.vue";
import { Head } from "@inertiajs/inertia-vue3";
import Input from "@/Components/Input.vue";
import InputError from "@/Components/InputError.vue";
</script>
<script>
import axios from "axios";

export default {
  components: {},
  data() {
    return {
      items: [],
      total: 0,
      filtered: 0,
      search: "",
      start: 0,
      length: 10,
      order: "",
      order_by: "name",
      order_type: "desc",
      submiting: false,
      modalId: "role-modal",
      modalDeleteId: "delete-modal",
      modalTitle: "Add Role",
      modalTextConfirm: "Add",
      modalTextCancel: "Cancel",
      textDelete: "",
      selectedRole: {
        name: "",
        description: "",
        default_redirect: "",
      },
      errorMsg: [],
    };
  },
  mounted() {
    this.initTableRoles();
  },
  methods: {
    initTableRoles() {
      let postData = {
        length: this.length,
        start: this.start,
        search: this.search,
        order_by: this.order_by,
        order_type: this.order_type,
      };
      axios.post("/backend/admin/role/listing", postData).then((response) => {
        if (response.status == 200 && response.data && response.data.data) {
          this.items = response.data.data;
          this.filtered = response.data.recordsFiltered;
          this.total = response.data.recordsTotal;
        }
      });
    },
    editRole(item) {
      this.modalTitle = "Edit Role";
      this.modalTextConfirm = "Update";
      this.selectedRole = item;
      document.getElementById(this.modalId).showModal();
    },
    addRole() {
      this.modalTitle = "Add Role";
      this.modalTextConfirm = "Add";
      document.getElementById(this.modalId).showModal();
    },
    deleteRole(role) {
      this.textDelete =
        'Are you sure to delete role <span class="text-red-500 font-semibold">' +
        role.name +
        "</span> ?";
      this.selectedRole = role;
      document.getElementById(this.modalDeleteId).showModal();
    },
    cancelDelete() {
      document.getElementById(this.modalDeleteId).showModal();
    },
    confirmDelete() {
      let vm = this;
      axios
        .post("/backend/admin/role/" + vm.selectedRole.id + "/delete")
        .then((response) => {
          vm.submiting = false;
          if (
            response.status == 200 &&
            response.data &&
            response.data.code == 0
          ) {
            document.getElementById(this.modalDeleteId).close();
            vm.$notify({
              title: "Notify",
              text: "Success",
              type: "success",
            });
          } else {
            if (response.data && response.data.msg) {
              vm.errorMsg.name = err.data.msg;
            } else {
              document.getElementById(this.modalDeleteId).close();
              vm.$notify({
                title: "Notify",
                text: "Something went wrong, please try later.",
                type: "error",
              });
            }
          }
        })
        .catch((err) => {
          vm.submiting = false;
          if (
            err.response.status == 422 &&
            err.response.data &&
            err.response.data.message
          ) {
            vm.errorMsg.name = err.response.data.message;
          } else {
            document.getElementById(this.modalId).close();
            vm.$notify({
              title: "Notify",
              text: "Something went wrong, please try later.",
              type: "error",
            });
          }
        });
    },
    handleCloseModal() {
      let vm = this;
      setTimeout(function () {
        vm.initTableRoles();
        vm.selectedRole = {
          name: "",
          description: "",
        };
      }, 500);
    },
    handleSubmitModal() {
      let vm = this;
      vm.submiting = true;
      if (!vm.selectedRole.name) {
        vm.errorMsg.name = "Please enter value";
        vm.submiting = false;
        return;
      }
      vm.errorMsg.name = "";
      vm.submiting = true;
      axios
        .post(
          "/backend/admin/role/" + vm.modalTextConfirm.toLowerCase(),
          vm.selectedRole
        )
        .then((response) => {
          vm.submiting = false;
          if (
            response.status == 200 &&
            response.data &&
            response.data.code == 0
          ) {
            document.getElementById(this.modalId).close();
            vm.$notify({
              title: "Notify",
              text: "Success",
              type: "success",
            });
          } else {
            if (response.data && response.data.msg) {
              vm.errorMsg.name = err.data.msg;
            } else {
              document.getElementById(this.modalId).close();
              vm.$notify({
                title: "Notify",
                text: "Something went wrong, please try later.",
                type: "error",
              });
            }
          }
        })
        .catch((err) => {
          vm.submiting = false;
          if (
            err.response.status == 422 &&
            err.response.data &&
            err.response.data.message
          ) {
            vm.errorMsg = err.response.data.errors;
          } else {
            document.getElementById(this.modalId).close();
            vm.$notify({
              title: "Notify",
              text: "Something went wrong, please try later.",
              type: "error",
            });
          }
        });
    },
  },
};
</script>

<template>
  <Head title="Role" />

  <BreezeAuthenticatedLayout>
    <template #header>
      <h2 class="font-semibold text-xl text-gray-800 leading-tight">Role</h2>
    </template>

    <Message-box
      @confirm="confirmDelete"
      @close="handleCloseModal"
      :modal-id="modalDeleteId"
      :title="'Delete Role'"
      :text-confirm="'Delete'"
      :textCancel="'Cancel'"
      :content="textDelete"
    ></Message-box>
    <Modal
      @close="handleCloseModal"
      @submit="handleSubmitModal"
      :submiting="submiting"
      :modal-id="modalId"
      :title="modalTitle"
      :text-confirm="modalTextConfirm"
      :text-cancel="modalTextCancel"
    >
      <div class="grid lg:grid-cols-2 md:grid-cols-1 gap-4">
        <div>
          <p class="mb-2 font-semibold text-gray-700">Role name</p>
          <Input v-model="selectedRole.name" type="text" />
        </div>
        <div>
          <p class="mb-2 font-semibold text-gray-700">Description</p>
          <Input v-model="selectedRole.description" />
        </div>
      </div>
      <div class="grid lg:grid-cols-2 md:grid-cols-1 gap-4">
        <div>
          <p class="mb-2 font-semibold text-gray-700">Default redirect</p>
          <Input v-model="selectedRole.default_redirect" type="text" />
        </div>
      </div>
      <InputError v-for="(err, key) in errorMsg" :message="err[0]"></InputError>
    </Modal>
    <div class="py-12">
      <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="overflow-hidden shadow-md">
          <!-- card header -->
          <div class="px-6 py-4 bg-white border-b border-gray-200 flex">
            <h3 class="font-bold uppercase">Role management</h3>
            <button
              @click="addRole"
              class="
                tracking-wider
                text-white
                bg-emerald-500
                px-4
                py-1
                text-sm
                rounded
                leading-loose
                mx-2
                ml-auto
                font-semibold
                flex
              "
              title=""
            >
              <img class="w-3 mt-2 mx-1" src="/imgs/plus-white.png" /> Add
            </button>
          </div>

          <!-- card body -->
          <div class="p-6 bg-white border-b border-gray-200">
            <div class="my-2 flex sm:flex-row flex-col">
              <div class="flex flex-row mb-1 sm:mb-0">
                <div class="relative">
                  <select
                    v-model="length"
                    @change="initTableRoles"
                    class="
                      appearance-none
                      h-full
                      rounded-l
                      border
                      block
                      appearance-none
                      w-full
                      bg-white
                      border-gray-400
                      text-gray-700
                      py-2
                      px-4
                      pr-8
                      leading-tight
                      focus:outline-none focus:bg-white focus:border-gray-500
                    "
                  >
                    <option>5</option>
                    <option>10</option>
                    <option>20</option>
                  </select>
                </div>
              </div>
              <div class="block relative">
                <input
                  v-model="search"
                  @keyup="initTableRoles"
                  placeholder="Search"
                  class="
                    appearance-none
                    rounded-r rounded-l
                    sm:rounded-l-none
                    border border-gray-400 border-b
                    block
                    pl-8
                    pr-6
                    py-2
                    w-full
                    bg-white
                    text-sm
                    placeholder-gray-400
                    text-gray-700
                    focus:bg-white
                    focus:placeholder-gray-600
                    focus:text-gray-700
                    focus:outline-none
                  "
                />
              </div>
            </div>
            <div class="-mx-4 sm:-mx-8 px-4 sm:px-8 py-4 overflow-x-auto">
              <div
                class="
                  inline-block
                  min-w-full
                  shadow
                  rounded-lg
                  overflow-hidden
                "
              >
                <table class="min-w-full leading-normal">
                  <thead>
                    <tr>
                      <th
                        class="
                          px-5
                          py-3
                          border-b-2 border-gray-200
                          bg-gray-100
                          text-left text-xs
                          font-semibold
                          text-gray-600
                          uppercase
                          tracking-wider
                        "
                      >
                        Action
                      </th>
                      <th
                        class="
                          px-5
                          py-3
                          border-b-2 border-gray-200
                          bg-gray-100
                          text-left text-xs
                          font-semibold
                          text-gray-600
                          uppercase
                          tracking-wider
                        "
                      >
                        Role name
                      </th>
                      <th
                        class="
                          px-5
                          py-3
                          border-b-2 border-gray-200
                          bg-gray-100
                          text-left text-xs
                          font-semibold
                          text-gray-600
                          uppercase
                          tracking-wider
                        "
                      >
                        Default redirect (after login)
                      </th>
                      <th
                        class="
                          px-5
                          py-3
                          border-b-2 border-gray-200
                          bg-gray-100
                          text-left text-xs
                          font-semibold
                          text-gray-600
                          uppercase
                          tracking-wider
                        "
                      >
                        Description
                      </th>
                      <th
                        class="
                          px-5
                          py-3
                          border-b-2 border-gray-200
                          bg-gray-100
                          text-left text-xs
                          font-semibold
                          text-gray-600
                          uppercase
                          tracking-wider
                        "
                      >
                        Created at
                      </th>
                      <th
                        class="
                          px-5
                          py-3
                          border-b-2 border-gray-200
                          bg-gray-100
                          text-left text-xs
                          font-semibold
                          text-gray-600
                          uppercase
                          tracking-wider
                        "
                      >
                        Updated at
                      </th>
                    </tr>
                  </thead>
                  <tbody>
                    <tr v-for="item in items">
                      <td
                        class="
                          px-5
                          py-5
                          border-b border-gray-200
                          bg-white
                          text-sm
                          flex
                        "
                      >
                        <button
                          @click="editRole(item)"
                          class="
                            tracking-wider
                            text-white
                            bg-blue-400
                            px-4
                            py-1
                            text-sm
                            rounded
                            leading-loose
                            mx-2
                            font-semibold
                            flex
                          "
                          title=""
                        >
                          <img class="w-3 mt-2 mx-1" src="/imgs/pencil.png" />
                          Edit
                        </button>
                        <button
                          @click="deleteRole(item)"
                          class="
                            tracking-wider
                            text-white
                            bg-red-400
                            px-4
                            py-1
                            text-sm
                            rounded
                            leading-loose
                            mx-2
                            font-semibold
                            flex
                          "
                          title=""
                        >
                          <img class="w-3 mt-2 mx-1" src="/imgs/trash.png" />
                          Delete
                        </button>
                      </td>
                      <td
                        class="
                          px-5
                          py-5
                          border-b border-gray-200
                          bg-white
                          text-sm
                        "
                      >
                        {{ item.name }}
                      </td>
                      <td
                        class="
                          px-5
                          py-5
                          border-b border-gray-200
                          bg-white
                          text-sm
                        "
                      >
                        {{ item.description }}
                      </td>
                      <td
                        class="
                          px-5
                          py-5
                          border-b border-gray-200
                          bg-white
                          text-sm
                        "
                      >
                        {{ item.default_redirect }}
                      </td>
                      <td
                        class="
                          px-5
                          py-5
                          border-b border-gray-200
                          bg-white
                          text-sm
                        "
                      >
                        {{ item.created_at }}
                      </td>

                      <td
                        class="
                          px-5
                          py-5
                          border-b border-gray-200
                          bg-white
                          text-sm
                        "
                      >
                        {{ item.updated_at }}
                      </td>
                    </tr>
                  </tbody>
                </table>
                <div
                  class="
                    px-5
                    py-5
                    bg-white
                    border-t
                    flex flex-col
                    xs:flex-row
                    items-center
                    xs:justify-between
                  "
                >
                  <span class="text-xs xs:text-sm text-gray-900">
                    Showing {{ start + 1 }} to {{ start + filtered }} of
                    {{ total }} Entries
                  </span>
                  <div class="inline-flex mt-2 xs:mt-0">
                    <button
                      class="
                        text-sm
                        bg-gray-300
                        hover:bg-gray-400
                        text-gray-800
                        font-semibold
                        py-2
                        px-4
                        rounded-l
                      "
                    >
                      Prev
                    </button>
                    <button
                      class="
                        text-sm
                        bg-gray-300
                        hover:bg-gray-400
                        text-gray-800
                        font-semibold
                        py-2
                        px-4
                        rounded-r
                      "
                    >
                      Next
                    </button>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </BreezeAuthenticatedLayout>
</template>
