
const storage = {
  setItem( item, value ) {
    return window.localStorage.setItem(item, value)
  },
  getItem( item ){
   return window.localStorage.getItem(item)
  },
  deleteItem( item ){
    return window.localStorage.removeItem(item)
  }
}
export default storage