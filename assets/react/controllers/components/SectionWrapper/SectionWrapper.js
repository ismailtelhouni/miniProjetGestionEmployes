import './SectionWrapper.css'

const SectionWrapper = (props) => {
  return (
    <div className='section-wrapper'>
        { props.children }
    </div>
  )
}

export default SectionWrapper