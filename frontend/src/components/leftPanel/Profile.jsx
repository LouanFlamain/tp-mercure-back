const Profile = ({ userImage }) => {
  return (
    <div className="w-10 rounded-full mr-4">
      <img className="rounded-full" src={`pp/${userImage}.jpeg`} />
    </div>
  );
};
export default Profile;
