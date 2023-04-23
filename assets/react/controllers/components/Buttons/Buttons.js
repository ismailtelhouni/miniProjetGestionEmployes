import './Buttons.css'

const PrimaryButton = (props) => {
  return (
    <div className='Button Primary-btn'>
        <a href='/#'>
            { props.children }
        </a>
    </div>
  )
}
const SecondaryButton = (props) => {
    return (
      <div className='Button Secondary-btn'>
        <a href='/#'>
            { props.children }
        </a>
    </div>
    )
  }

export default PrimaryButton
export { SecondaryButton }