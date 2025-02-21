

export const formatDateForInput = (date) => {
    if (!date) return ''
    return new Date(date).toISOString().split('T')[0]
}
  
export  const formatSortedDate = (date) => {
    if (!date) return ''
    return new Date(date).toLocaleDateString('fr-FR', {
      year: 'numeric',
      month: 'short',
    })
    .replace(/^./, (char) => char.toUpperCase());
}

export const formatFullDate = (date) => {
    if (!date) return ''
    return new Date(date).toLocaleDateString('fr-FR', {
      year: 'numeric',
      month: 'long',
      day: 'numeric'
    })
    .replace(/^./, (char) => char.toUpperCase());
}

export const formattedNormalDate = (date) => {
  if (!date) return ''
  return new Date(date).toLocaleDateString('fr-FR', {
    day: '2-digit',
    month: '2-digit',
    year: 'numeric'
  })
}

