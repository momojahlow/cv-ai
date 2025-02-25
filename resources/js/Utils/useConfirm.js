import Swal from "sweetalert2";

/**
 * Reusable confirmation dialog using SweetAlert2
 * @param {string} title - The confirmation message title
 * @param {string} text - Additional message (optional)
 * @param {string} confirmButtonText - The text for the confirm button
 * @returns {Promise<boolean>} - Returns true if confirmed, false otherwise
 */
export const confirmDelete = async (
  title = "Êtes-vous sûr ?",
  text = "Cette action est irréversible.",
  confirmButtonText = "Oui, supprimer !"
) => {
  const result = await Swal.fire({
    title: '<span style="font-size: 1.3rem; color: #d33;">'+title+'</span>',
    text,
    // icon: "question",
    width: "350px",
    showCancelButton: true,
    confirmButtonColor: "#d33",
    cancelButtonColor: "#c0997a",
    confirmButtonText,
    cancelButtonText: "Annuler",
  });

  return result.isConfirmed;
};