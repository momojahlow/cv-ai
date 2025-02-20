import Swal from "sweetalert2";

const Toast = Swal.mixin({
  toast: true,
  position: "top-end",
  showConfirmButton: false,
  timer: 2000,
  timerProgressBar: true,
  didOpen: (toast) => {
    toast.onmouseenter = Swal.stopTimer;
    toast.onmouseleave = Swal.resumeTimer;
    toast.style.fontSize = "13px";
  }
});

export const showToast = (icon = "success", title = "Action réussie") => {
  Toast.fire({ icon, title });
};