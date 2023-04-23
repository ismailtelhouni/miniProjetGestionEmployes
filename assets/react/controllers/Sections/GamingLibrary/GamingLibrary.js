import './GamingLibrary.css'
import { GamingLibraryCard , SectionHeader , SectionWrapper} from '../../components'
import { default as GamingLibraryData } from '../../Data/GamingLibraryData'


const GamingLibrary = () => {
    const Cards = GamingLibraryData.map(card => {
      return <GamingLibraryCard key={ card.id } image={ card.image } title={ card.title } category={ card.category } date_added={ card.date_added } hours_played={ card.hours_played } download={ card.download }/>
    })
  return (
    <>
        <SectionWrapper>
            <SectionHeader>Gaming Library </SectionHeader>
            <div className='gaming-library-cards'>
                { Cards }
            </div>
        </SectionWrapper>
    </>
  )
}

export default GamingLibrary