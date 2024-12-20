import React, {useState} from 'react'

const Categ = () => {
    const data = [
    {
      cateImg: "./img/logopizza.jpg",
      cateName: "Pizza",
    },
    {
      cateImg: "./img/burgerlogo.jpg",
      cateName: "Hamburger King",
    },
   
    ]

    const SunnyData =[
      {
        cateImg: "./img/banhkem.jpg",
        cateName: "Bánh kem cute",
      },
      {
        cateImg: "./img/suplogo.jpg",
        cateName: "Soup",
      },
     
    ]

  const [Active, setActive] = useState(true)
  return (
    <div className="cate products">
        <div className="cateHeading flex">
            <h1 onClick={()=>{
              if(Active) {
                setActive(false)
              }
              else {
                setActive(true)
              }
            }}>
              {
                Active ? "Món chính (pizza)" : "Món phụ"
              }
            <span className='sunnymargin'>|</span> 
            <span className='change'>
            {
              Active ? "Món phụ" : "Món chính (pizza)"
            }
            </span>
            
            </h1>
        </div>
        {
          Active ? 
        <>
          {
              data.map((value,index)=>{
                  return(
                      <div className="box flex">
                        <div className="imgDiv">
                          <img src={value.cateImg} alt="" />
                        </div>
                        <h3>{value.cateName}</h3>
                      </div>
                  )
              })
          }
        </>
        :
        <>
          {
              SunnyData.map((value,index)=>{
                  return(
                      <div className="box sunny flex">
                        <div className="imgDiv">
                          <img src={value.cateImg} alt="" />
                        </div>
                        <h3>{value.cateName}</h3>
                      </div>
                  )
              })
          }
        </>
        }
    </div>
  )
}

export default Categ